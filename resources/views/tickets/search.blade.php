<form class="w-full max-w-sm" action="{{ route('tickets.search') }}" method="POST">
    @csrf
    <div class="flex items-center border-b border-teal-500 py-2">
        <input name="case_number" id="case_number" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Enter Ticket Number" aria-label="Ticket Number" required>
        <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="submit">
            Search
        </button>
        <button class="flex-shrink-0 border-red-500 hover:border-red-700 bg-red-500 hover:bg-red-700 border-4 text-white text-sm py-1 px-2 mx-1 rounded" type="button">
            <a href="{{ route('tickets.create') }}">
                New Ticket
            </a>
        </button>
    </div>
</form>