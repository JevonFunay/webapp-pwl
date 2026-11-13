@php
    $navigation = [['route' => 'dashboard', 'label' => 'Dashboard']];
    if (auth()->user()->role === 'dosen') {
        $navigation = array_merge($navigation, [
            ['route' => 'mahasiswa.index', 'label' => 'Mahasiswa'],
            ['route' => 'dosen.index', 'label' => 'Dosen'],
            ['route' => 'matakuliah.index', 'label' => 'Mata Kuliah'],
            ['route' => 'jadwal.index', 'label' => 'Jadwal'],
        ]);
    }
    $navigation[] = ['route' => 'registrasi.index', 'label' => 'Registrasi'];
@endphp

<nav x-data="{ open: false }" class="border-b border-gray-100 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-4">
            <div class="flex min-w-0 items-center gap-6">
                <a href="{{ route('dashboard') }}" class="shrink-0" aria-label="Dashboard">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
                <div class="hidden h-16 items-stretch gap-5 lg:flex">
                    @foreach ($navigation as $link)
                        <x-nav-link :href="route($link['route'])" :active="request()->routeIs(str_replace('.index', '.*', $link['route']))" class="whitespace-nowrap">
                            {{ $link['label'] }}
                        </x-nav-link>
                    @endforeach
                </div>
            </div>

            <div class="hidden shrink-0 lg:block">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium text-gray-600 transition hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <span class="max-w-[10rem] truncate">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 shrink-0 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-start text-sm text-gray-700 transition hover:bg-gray-100 focus:bg-gray-100 focus:outline-none">Logout</button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <button @click="open = ! open" :aria-expanded="open.toString()" aria-controls="mobile-navigation" aria-label="Buka navigasi" class="inline-flex items-center justify-center rounded-md p-2 text-gray-500 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 lg:hidden">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-navigation" :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="space-y-1 pb-3 pt-2">
            @foreach ($navigation as $link)
                <x-responsive-nav-link :href="route($link['route'])" :active="request()->routeIs(str_replace('.index', '.*', $link['route']))">
                    {{ $link['label'] }}
                </x-responsive-nav-link>
            @endforeach
        </div>
        <div class="border-t border-gray-200 pb-3 pt-4">
            <div class="px-4">
                <div class="break-words text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="break-words text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full border-l-4 border-transparent py-2 pe-4 ps-3 text-start text-base font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-800 focus:outline-none">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
