<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="h3 fw-bold text-dark">Create Account</h2>
        <p class="text-muted">Start your journey today</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" class="form-control form-control-lg" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" placeholder="Your Name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-control form-control-lg" type="email" name="email"
                :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-control form-control-lg" type="password" name="password" required
                autocomplete="new-password" placeholder="Create a password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="form-control form-control-lg" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a class="text-decoration-none small" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-dark btn-lg">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
