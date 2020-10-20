<div>
    <h2>Update Profile Information</h2>
    <div>

        <form method="POST" action="{{ route('user-profile-information.update') }}">
            @csrf
            @method('PUT')

            <div>
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" value="{{ old('name') ?? auth()->user()->name }}" required autofocus
                    autocomplete="name" />
            </div>

            <div>
                <label for="email">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') ?? auth()->user()->email }}" required autofocus />
            </div>

            <div>
                <button type="submit">
                    {{ __('Update Profile') }}
                </button>
            </div>

        </form>
    </div>
</div>
