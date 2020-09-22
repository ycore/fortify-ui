@if ($errors->any())
    <div class="mx-auto my-4 bg-red-100 border border-red-400 rounded-lg shadow-lg sm:w-1/2">
        <div class="mx-2 text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

        <ul class="mx-4 mt-3 text-sm text-red-600 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
