<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Short URLs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (!auth()->user()->isSuperAdmin())
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('short-urls.create') }}"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Create Short URL
                            </a>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Short URL</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Original URL</th>
                                    @if (auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Created By</th>
                                    @endif
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created At</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($shortUrls as $shortUrl)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ url('/s/' . $shortUrl->short_code) }}" target="_blank"
                                                class="text-blue-500 hover:underline">
                                                {{ url('/s/' . $shortUrl->short_code) }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ $shortUrl->original_url }}" target="_blank"
                                                class="text-blue-500 hover:underline">
                                                {{ Str::limit($shortUrl->original_url, 50) }}
                                            </a>
                                        </td>
                                        @if (auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $shortUrl->user->name }}</td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $shortUrl->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
