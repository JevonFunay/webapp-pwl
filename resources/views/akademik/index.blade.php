<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ $title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <p class="text-sm text-gray-600">Daftar data akademik.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="whitespace-nowrap px-6 py-3 text-left font-semibold text-gray-700">No.</th>
                                @foreach ($columns as $label)
                                    <th scope="col" class="whitespace-nowrap px-6 py-3 text-left font-semibold text-gray-700">{{ $label }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($rows as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $rows->firstItem() + $loop->index }}</td>
                                    @foreach ($columns as $key => $label)
                                        <td class="px-6 py-4 text-gray-800">{{ data_get($row, $key) ?? '—' }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($columns) + 1 }}" class="px-6 py-10 text-center text-gray-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-gray-100 px-6 py-4">{{ $rows->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
