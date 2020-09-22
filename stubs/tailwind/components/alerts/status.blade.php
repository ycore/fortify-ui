@if (session('status'))
    <div class="mx-auto my-2 bg-green-100 border border-green-400 rounded-lg shadow-lg sm:w-1/2">
        <div class="mx-2 my-2 text-green-600">
            {{ session('status') }}
        </div>
    </div>
@endif
