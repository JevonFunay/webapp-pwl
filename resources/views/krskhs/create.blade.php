<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Jadwal</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg bg-green-50 p-4 text-sm text-green-800" role="status">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="rounded-lg bg-red-50 p-4 text-sm text-red-800" role="alert">
                    @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 p-5">
                    <p class="text-sm text-gray-600">Pilih jadwal untuk registrasi <span class="font-semibold">{{ $registrasi->noReg }}</span>.</p>
                    <a href="{{ route('registrasi.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">Kembali ke KRS</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr><th class="px-4 py-3">No.</th><th class="px-4 py-3">Hari</th><th class="px-4 py-3">Waktu</th><th class="px-4 py-3">Mata Kuliah</th><th class="px-4 py-3">SKS</th><th class="px-4 py-3">Grup</th><th class="px-4 py-3">Dosen</th><th class="px-4 py-3">Ruang</th><th class="px-4 py-3">Aksi</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-800">
                            @forelse ($jadwal as $schedule)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $schedule->hari ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3">{{ $schedule->waktu }}</td>
                                    <td class="px-4 py-3">{{ $schedule->matakuliah?->namaMK ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $schedule->matakuliah?->sks ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $schedule->grup }}</td>
                                    <td class="px-4 py-3">{{ $schedule->dosen?->namaDosen ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3">{{ $schedule->ruang }}</td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('krskhs.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="jadwalId" value="{{ $schedule->jadwalId }}">
                                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700">Pilih</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="px-4 py-10 text-center text-gray-500">Tidak ada jadwal lain yang tersedia.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
