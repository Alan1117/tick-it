<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket: ' .$ticket->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if($ticket->is_resolved)
                    <div class="p-6 text-white bg-green-400">
                        <p class="bold">Resolved!</p>
                    </div>
                    <div class="p-6 text-white bg-red-300">
                        Not Happy?
                        <button class="flex-shrink-0 border-red-500 hover:border-red-700 bg-red-500 hover:bg-red-700 border-4 text-white text-sm py-1 px-2 mx-1 rounded" type="button">
                            <a href="{{ route('tickets.reopen', $ticket->id) }}">
                                Re-Open
                            </a>
                        </button>
                    </div>
                @endif
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="bold">Case</p>
                    <p class="bold">{{ $ticket->ticketType->description }}</p>
                    <p>{{ $ticket->description }}</p>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="bold">Created</p>
                    <p>{{ \Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d H:i') }}</p>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="bold">Current Status</p>
                    <p>{{ $ticket->ticketStatus->description}}</p>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="bold">Last Updated</p>
                    <p>{{ \Carbon\Carbon::parse($ticket->updated_at)->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full border border-gray-400 shadow-sm rounded">
                        <thead>
                        <tr class="bg-gray-100 dark:bg-gray-950 text-left">
                            <th class="px-4 py-2 border-b border-gray-200 text-gray-700 dark:text-gray-200 font-semibold">Previous Status</th>
                            <th class="px-4 py-2 border-b border-gray-200 text-gray-700 dark:text-gray-200 font-semibold">New Status</th>
                            <th class="px-4 py-2 border-b border-gray-200 text-gray-700 dark:text-gray-200 font-semibold">Reason (If Any)</th>
                            <th class="px-4 py-2 border-b border-gray-200 text-gray-700 dark:text-gray-200 font-semibold">Updated</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ticket->histories as $h)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b border-gray-200 text-gray-400">{{ $h?->previousTicketStatus?->description }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 text-gray-400">{{ $h?->currentTicketStatus?->description }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 text-gray-400">{{ $h->reason }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 text-gray-400">{{ \Carbon\Carbon::parse($h->created_at)->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
