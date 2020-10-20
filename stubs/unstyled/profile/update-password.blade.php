<div>
    <h2>Update Password</h2>
    <div>
        <form method="POST" action="{{ route('user-password.update') }}">
            @csrf
            @method('PUT')

            <div>
                <label for="password">{{ __('Current Password') }}</label>
                <input type="password" name="current_password" required autocomplete="current-password" />
            </div>

            <div>
                <label for="password">{{ __('New Password') }}</label>
                <input type="password" name="password" required autocomplete="new-password" />
            </div>

            <div>
                <label for="password">{{ __('Confirm Password') }}</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div>
                <button type="submit">
                    {{ __('Update Password') }}
                </button>
            </div>

        </form>
    </div>
</div>
