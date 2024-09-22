<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Ticket') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form class="w-full max-w-lg" action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        <div class="flex flex-wrap -mx-3 mb-2">
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-200 text-xs font-bold mb-2" for="ticket_type_id">
                                    Type
                                </label>
                                <div class="relative">
                                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                            id="ticket_type_id" name="ticket_type_id">
                                        <option value="">Select A Type</option>
                                        @forelse($ticketTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->description }}</option>
                                        @empty
                                            <option value="">No Options Available</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-200 text-xs font-bold mb-2" for="title">
                                    Title
                                </label>
                                <input type="text" id="title" name="title" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-grey-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-200 text-xs font-bold mb-2" for="description">
                                    Description
                                </label>
                                <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-grey-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="description" name="description" rows="4" placeholder="Enter description here..."></textarea>
                            </div>
                        </div>
                        <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="submit">
                            Submit
                        </button>
                        <button class="flex-shrink-0 border-red-500 hover:border-red-700 bg-red-500 hover:bg-red-700 border-4 text-white text-sm py-1 px-2 mx-1 rounded" type="button">
                            <a href="{{ route('dashboard') }}">
                                Cancel
                            </a>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
