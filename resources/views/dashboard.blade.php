

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(auth()->user()->isSuperAdmin())
                        <p>Welcome Super Admin!</p>
                        <p>You can manage companies and invite admins.</p>
                    @elseif(auth()->user()->isAdmin())
                        <p>Welcome Admin!</p>
                        <p>You can manage your company and invite members.</p>
                    @else
                        <p>Welcome Member!</p>
                        <p>You can create and manage your short URLs.</p>
                    @endif
                    
                    <!-- Add Create Short URL Button for Non-SuperAdmins -->
                    @if(!auth()->user()->isSuperAdmin())
                        <div class="mt-6">
                            <a href="{{ route('short-urls.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Create Short URL
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>