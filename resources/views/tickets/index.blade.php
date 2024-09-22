<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @include('tickets.search')
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <ul class="bg-gray-400 shadow sm:rounded-md">
                        @forelse($tickets as $ticket)
                            <li>
                                <div class="px-4 py-5 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">Case Number: {{ $ticket->id }}</h3>
                                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Ticket Type: {{ $ticket?->ticketType?->description }}</p>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-500">Status: <span
                                                    class="text-green-600">{{ $ticket?->ticketStatus?->description }}</span></p>
                                        <a href="{{ route('tickets.show', $ticket->id) }}" class="font-medium text-indigo-600 hover:text-indigo-500">View</a>
                                    </div>
                                </div>
                            </li>
                        @empty
                    <li>
                            <div class="px-4 py-5 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">No Tickets Logged</h3>
                                </div>
                            </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
