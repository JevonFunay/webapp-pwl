<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="rounded-lg bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h3 class="text-2xl font-semibold text-gray-900">Selamat datang, {{ auth()->user()->name }}</h3>
                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium capitalize text-indigo-700">{{ auth()->user()->role }}</span>
                </div>
                @if (auth()->user()->role === 'dosen')
                    <p class="mt-3 text-gray-600">Lihat data akademik dan KRS mahasiswa melalui menu berikut.</p>
                    <a href="{{ route('registrasi.index') }}" class="mt-5 inline-flex rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">Lihat Registrasi Mahasiswa</a>
                @elseif (auth()->user()->nim)
                    <p class="mt-3 text-gray-600">NIM: <span class="font-medium text-gray-900">{{ auth()->user()->nim }}</span></p>
                    <a href="{{ route('registrasi.index') }}" class="mt-5 inline-flex rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">Buka Registrasi dan KRS</a>
                @else
                    <p class="mt-4 rounded-md bg-amber-50 p-4 text-sm text-amber-800">NIM belum terhubung. Hubungi dosen untuk mengaktifkan akses registrasi.</p>
                @endif
            </section>

            @if (auth()->user()->role === 'dosen')
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <a href="{{ route('mahasiswa.index') }}" class="rounded-lg bg-white p-6 font-semibold text-gray-800 shadow-sm transition hover:bg-indigo-50">Data Mahasiswa</a>
                    <a href="{{ route('dosen.index') }}" class="rounded-lg bg-white p-6 font-semibold text-gray-800 shadow-sm transition hover:bg-indigo-50">Data Dosen</a>
                    <a href="{{ route('matakuliah.index') }}" class="rounded-lg bg-white p-6 font-semibold text-gray-800 shadow-sm transition hover:bg-indigo-50">Data Mata Kuliah</a>
                    <a href="{{ route('jadwal.index') }}" class="rounded-lg bg-white p-6 font-semibold text-gray-800 shadow-sm transition hover:bg-indigo-50">Data Jadwal</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
