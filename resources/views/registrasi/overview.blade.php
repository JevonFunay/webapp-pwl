<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Registrasi Mahasiswa</h2>
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
                <div class="border-b border-gray-100 p-5">
                    <p class="text-sm text-gray-600">Lihat registrasi dan KRS mahasiswa.</p>
                    <span class="mt-3 inline-block rounded-md bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">Mode Lihat Data — Dosen</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr><th class="px-5 py-3">No. Reg</th><th class="px-5 py-3">Tanggal</th><th class="px-5 py-3">NIM</th><th class="px-5 py-3">Nama Mahasiswa</th><th class="px-5 py-3">Jumlah KRS</th><th class="px-5 py-3">Aksi</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-800">
                            @forelse ($registrasis as $registrasi)
                                <tr>
                                    <td class="px-5 py-4">{{ $registrasi->noReg }}</td>
                                    <td class="whitespace-nowrap px-5 py-4">{{ $registrasi->tanggal?->format('d-m-Y') ?? '-' }}</td>
                                    <td class="px-5 py-4">{{ $registrasi->nim ?? '-' }}</td>
                                    <td class="px-5 py-4">{{ $registrasi->mahasiswa?->nama ?? '-' }}</td>
                                    <td class="px-5 py-4">{{ $registrasi->krskhs_count }}</td>
                                    <td class="px-5 py-4"><a href="{{ route('registrasi.show', $registrasi) }}" class="whitespace-nowrap font-semibold text-indigo-600 hover:underline">Lihat KRS</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-5 py-10 text-center text-gray-500">Belum ada data registrasi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-gray-100 p-5">{{ $registrasis->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
