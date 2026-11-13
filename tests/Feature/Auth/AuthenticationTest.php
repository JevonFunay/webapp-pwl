<?php

namespace Tests\Feature\Auth;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'login' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'login' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_students_can_log_in_with_nim_and_are_sent_to_registration(): void
    {
        Mahasiswa::create(['nim' => '72240001', 'nama' => 'Mahasiswa Contoh', 'kota' => 'Yogyakarta']);
        $student = User::factory()->create(['nim' => '72240001', 'role' => 'mahasiswa']);

        $this->post('/login', ['login' => $student->nim, 'password' => 'password'])
            ->assertRedirect(route('registrasi.index'));

        $this->assertAuthenticatedAs($student);
    }

    public function test_lecturers_are_sent_to_dashboard_after_email_login(): void
    {
        $lecturer = User::factory()->create(['role' => 'dosen']);

        $this->post('/login', ['login' => $lecturer->email, 'password' => 'password'])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($lecturer);
    }

    public function test_login_is_temporarily_blocked_after_five_failed_attempts(): void
    {
        $user = User::factory()->create();

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/login', ['login' => $user->email, 'password' => 'wrong-password'])
                ->assertSessionHasErrors('login');
        }

        $this->post('/login', ['login' => $user->email, 'password' => 'password'])
            ->assertSessionHasErrors('login');

        $this->assertGuest();
    }

    public function test_failed_attempts_for_one_identifier_do_not_block_another_user(): void
    {
        $first = User::factory()->create();
        $second = User::factory()->create();

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/login', ['login' => $first->email, 'password' => 'wrong-password']);
        }

        $this->post('/login', ['login' => $second->email, 'password' => 'password'])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($second);
    }
}
