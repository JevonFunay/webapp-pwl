<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Krskhs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Registrasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicAccessTest extends TestCase
{
    use RefreshDatabase;

    private int $scheduleSequence = 0;

    public function test_guests_must_log_in_before_opening_academic_pages(): void
    {
        foreach (['/mahasiswa', '/registrasi', '/krskhs/create', '/krskhs/pdf'] as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }
    }

    public function test_students_cannot_open_lecturer_master_pages(): void
    {
        $student = $this->student('72240001');

        foreach (['/mahasiswa', '/dosen', '/matakuliah', '/jadwal'] as $url) {
            $this->actingAs($student)->get($url)->assertForbidden();
        }
    }

    public function test_lecturers_can_open_master_pages(): void
    {
        $lecturer = User::factory()->create(['role' => 'dosen']);

        foreach (['/mahasiswa', '/dosen', '/matakuliah', '/jadwal'] as $url) {
            $this->actingAs($lecturer)->get($url)->assertOk();
        }
    }

    public function test_students_only_see_their_latest_registration_and_own_krs(): void
    {
        $student = $this->student('72240001');
        $otherStudent = $this->student('72240002');
        $older = $this->registration($student);
        $latest = $this->registration($student);
        $other = $this->registration($otherStudent);
        $schedule = $this->schedule();
        $this->krs($older, $schedule);
        $entry = $this->krs($latest, $schedule);
        $this->krs($other, $schedule);

        $this->actingAs($student)->get('/registrasi')
            ->assertOk()
            ->assertViewIs('registrasi.index')
            ->assertViewHas('registrasi', fn (Registrasi $registration) => $registration->is($latest))
            ->assertViewHas('krskhs', fn ($entries) => $entries->pluck('idKrs')->all() === [$entry->idKrs]);

        $this->get(route('registrasi.show', $other))->assertForbidden();
    }

    public function test_opening_registration_creates_it_once_when_student_has_none(): void
    {
        $student = $this->student('72240001');

        $this->actingAs($student)->get('/registrasi')->assertOk();
        $this->get('/registrasi')->assertOk();

        $this->assertDatabaseCount('registrasis', 1);
        $this->assertDatabaseHas('registrasis', ['nim' => $student->nim]);
    }

    public function test_unlinked_students_are_directed_to_their_profile(): void
    {
        $student = User::factory()->create(['role' => 'mahasiswa', 'nim' => null]);

        $this->actingAs($student)->get('/registrasi')->assertRedirect(route('profile.edit'));

        $this->assertDatabaseCount('registrasis', 0);
    }

    public function test_lecturers_can_view_all_registrations_and_read_only_krs(): void
    {
        $first = $this->registration($this->student('72240001'));
        $second = $this->registration($this->student('72240002'));
        $lecturer = User::factory()->create(['role' => 'dosen']);

        $this->actingAs($lecturer)->get('/registrasi')
            ->assertOk()
            ->assertViewIs('registrasi.overview')
            ->assertViewHas('registrasis', fn ($registrations) => $registrations->count() === 2);

        foreach ([$first, $second] as $registration) {
            $this->get(route('registrasi.show', $registration))
                ->assertOk()
                ->assertViewHas('readOnly', true);
        }
    }

    public function test_lecturers_cannot_add_or_delete_krs(): void
    {
        $registration = $this->registration($this->student('72240001'));
        $schedule = $this->schedule();
        $entry = $this->krs($registration, $schedule);
        $lecturer = User::factory()->create(['role' => 'dosen']);

        $this->actingAs($lecturer)->get('/krskhs/create')->assertForbidden();
        $this->post('/krskhs', ['jadwalId' => $schedule->jadwalId])->assertForbidden();
        $this->delete(route('krskhs.destroy', $entry))->assertForbidden();

        $this->assertDatabaseCount('krskhs', 1);
        $this->assertModelExists($entry);
    }

    public function test_students_cannot_spoof_the_registration_when_adding_a_schedule(): void
    {
        $student = $this->student('72240001');
        $own = $this->registration($student);
        $other = $this->registration($this->student('72240002'));
        $schedule = $this->schedule();

        $this->actingAs($student)
            ->withSession(['noReg' => $other->noReg])
            ->post('/krskhs', ['noReg' => $other->noReg, 'jadwalId' => $schedule->jadwalId])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('registrasi.index'));

        $this->assertDatabaseHas('krskhs', ['noReg' => $own->noReg, 'jadwalId' => $schedule->jadwalId]);
        $this->assertDatabaseMissing('krskhs', ['noReg' => $other->noReg, 'jadwalId' => $schedule->jadwalId]);
    }

    public function test_selecting_the_same_schedule_twice_does_not_duplicate_krs(): void
    {
        $student = $this->student('72240001');
        $registration = $this->registration($student);
        $schedule = $this->schedule();

        $this->actingAs($student)->post('/krskhs', ['jadwalId' => $schedule->jadwalId])
            ->assertRedirect(route('registrasi.index'));
        $this->post('/krskhs', ['jadwalId' => $schedule->jadwalId])
            ->assertRedirect(route('registrasi.index'));

        $this->assertDatabaseCount('krskhs', 1);
        $this->assertDatabaseHas('krskhs', ['noReg' => $registration->noReg, 'jadwalId' => $schedule->jadwalId]);
    }

    public function test_students_can_delete_their_own_krs_but_not_another_students(): void
    {
        $student = $this->student('72240001');
        $own = $this->registration($student);
        $other = $this->registration($this->student('72240002'));
        $schedule = $this->schedule();
        $ownEntry = $this->krs($own, $schedule);
        $otherEntry = $this->krs($other, $schedule);

        $this->actingAs($student)->delete(route('krskhs.destroy', $otherEntry))->assertForbidden();
        $this->assertModelExists($otherEntry);

        $this->delete(route('krskhs.destroy', $ownEntry))->assertRedirect(route('registrasi.index'));
        $this->assertModelMissing($ownEntry);
        $this->assertModelExists($otherEntry);
    }

    public function test_students_and_lecturers_can_print_an_authorized_krs_as_pdf(): void
    {
        $student = $this->student('72240001');
        $registration = $this->registration($student);
        $this->krs($registration, $this->schedule());
        $lecturer = User::factory()->create(['role' => 'dosen']);

        foreach ([$student, $lecturer] as $user) {
            $response = $this->actingAs($user)->get(route('krskhs.pdf', [
                'noReg' => $registration->noReg,
            ]));

            $response->assertOk()->assertHeader('content-type', 'application/pdf');
            $this->assertStringStartsWith('%PDF-', $response->getContent());
        }
    }

    public function test_students_cannot_print_another_students_krs(): void
    {
        $student = $this->student('72240001');
        $this->registration($student);
        $other = $this->registration($this->student('72240002'));

        $this->actingAs($student)->get(route('krskhs.pdf', ['noReg' => $other->noReg]))
            ->assertForbidden();
    }

    private function student(string $nim): User
    {
        $student = Mahasiswa::create(['nim' => $nim, 'nama' => 'Mahasiswa '.$nim, 'kota' => 'Yogyakarta']);

        return User::factory()->create([
            'nim' => $student->nim,
            'name' => $student->nama,
            'email' => $nim.'@example.test',
            'role' => 'mahasiswa',
        ]);
    }

    private function registration(User $student): Registrasi
    {
        return Registrasi::create(['nim' => $student->nim, 'tanggal' => '2026-11-08']);
    }

    private function schedule(): Jadwal
    {
        $code = 'MK'.str_pad((string) ++$this->scheduleSequence, 4, '0', STR_PAD_LEFT);
        $lecturer = Dosen::firstOrCreate(['nik' => '1000001'], ['namaDosen' => 'Dosen Contoh']);
        $course = Matakuliah::create(['kodeMK' => $code, 'namaMK' => 'Mata Kuliah '.$code, 'sks' => 3]);

        return Jadwal::create([
            'hari' => 'Senin',
            'waktu' => '07.30-10.20',
            'kodeMK' => $course->kodeMK,
            'grup' => 'A',
            'nik' => $lecturer->nik,
            'ruang' => 'B.101',
        ]);
    }

    private function krs(Registrasi $registration, Jadwal $schedule): Krskhs
    {
        return Krskhs::create([
            'noReg' => $registration->noReg,
            'jadwalId' => $schedule->jadwalId,
            'nilai' => 'A',
        ]);
    }
}
