<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Kartu Rencana Studi</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg bg-green-50 p-4 text-sm text-green-800" role="status">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="rounded-lg bg-red-50 p-4 text-sm text-red-800" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 p-5">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('krskhs.pdf', ['noReg' => $registrasi->noReg]) }}" target="_blank" rel="noopener"
                           class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Print KRS</a>
                        @if (! $readOnly)
                            <a href="{{ route('krskhs.create') }}" class="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">Tambah Jadwal</a>
                        @else
                            <span class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-600">Mode Lihat Data — Dosen</span>
                        @endif
                    </div>
                    @if ($readOnly)
                        <a href="{{ route('registrasi.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">Kembali ke daftar registrasi</a>
                    @endif
                </div>

                <dl class="grid gap-4 p-5 text-sm sm:grid-cols-2 lg:grid-cols-4">
                    <div><dt class="text-gray-500">No. Registrasi</dt><dd class="mt-1 font-semibold text-gray-900">{{ $registrasi->noReg }}</dd></div>
                    <div><dt class="text-gray-500">NIM</dt><dd class="mt-1 font-semibold text-gray-900">{{ $registrasi->nim ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Nama Mahasiswa</dt><dd class="mt-1 font-semibold text-gray-900">{{ $registrasi->mahasiswa?->nama ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Tanggal Registrasi</dt><dd class="mt-1 font-semibold text-gray-900">{{ $registrasi->tanggal?->format('d-m-Y') ?? '-' }}</dd></div>
                </dl>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-3">No.</th><th class="px-4 py-3">Hari</th><th class="px-4 py-3">Waktu</th>
                                <th class="px-4 py-3">Mata Kuliah</th><th class="px-4 py-3">SKS</th><th class="px-4 py-3">Grup</th>
                                <th class="px-4 py-3">Dosen</th><th class="px-4 py-3">Ruang</th><th class="px-4 py-3">Nilai</th>
                                @if (! $readOnly)<th class="px-4 py-3">Aksi</th>@endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-800">
                            @forelse ($krskhs as $entry)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="whitespace-nowrap px-4 py-3">{{ $entry->jadwal?->hari ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3">{{ $entry->jadwal?->waktu ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $entry->jadwal?->matakuliah?->namaMK ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $entry->jadwal?->matakuliah?->sks ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $entry->jadwal?->grup ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $entry->jadwal?->dosen?->namaDosen ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3">{{ $entry->jadwal?->ruang ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $entry->nilai }}</td>
                                    @if (! $readOnly)
                                        <td class="px-4 py-3">
                                            <form action="{{ route('krskhs.destroy', $entry) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini dari KRS?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-md bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr><td colspan="{{ $readOnly ? 9 : 10 }}" class="px-4 py-10 text-center text-gray-500">Belum ada jadwal yang dipilih.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="border-t border-gray-100 p-5 text-sm font-semibold text-gray-700">
                    Total SKS: {{ $krskhs->sum(fn ($entry) => (int) ($entry->jadwal?->matakuliah?->sks ?? 0)) }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
