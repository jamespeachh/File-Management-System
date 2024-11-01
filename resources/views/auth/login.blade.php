{{--<link rel="stylesheet" href="{{asset('htmlData/css/templates/login-form.css')}}">--}}

<style>
    :root {
        --login-bg-color: white;
        --form-text-color: black;
        --button-background-color: darkgray;
        --background-main: 51 51 51;
        --background-form:117 117 116;
        --form-bg-opacity:0.5;
        --main-bg-opacity:1;
        --color-abstract: 170 204 230;
    }

    body {
        font-family: 'REM', sans-serif;
        background-color: rgb(var(--background-main) / var(--main-bg-opacity));
    }

    .full-form{
        width: 40%;
        border-radius: 25px;
        margin: auto;
        padding-top: 5vh;
        padding-bottom: 5vh;
        background-color: rgb(var(--background-form) / var(--form-bg-opacity));
    }

    .form-text-input {
        border-radius: 10px;
        height: 30px;
        width: 70%;
        margin-top: 15px;
        margin-bottom: 10px;
        padding-left: 8px;
    }

    .form-button-input {
        height: 30px;
        width: 70px;
        background-color: var(--button-background-color);
        border-radius: 10px;
        border: none;
    }
    .form-button-input:hover{
        background-color: gray;
    }
    .form-item{
        margin-left: 20%;
    }

    .form-label{
        color: white;
        font-weight: 900;
    }

    .password-link{
        color: rgb(var(--color-abstract));
    }
    .line{
        margin-bottom: 20px;
        margin-top: 5px;
    }
    .form-header{
        color: white;
        text-align: center;
        margin-top: 0;
    }

    @media (max-width:900px) {
        .full-form{
            width: 60%;
        }
        .form-item{
            margin-left: 15%;
        }
    }

</style>

<div class="full-form">
    <h1 class="form-header">YCL</h1>
    <hr class="line">
    <x-guest-layout>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="form-item form-label" />
                <br>
                <x-text-input id="email" class="block mt-1 w-full form-text-input form-item" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="form-item form-label" />
                <br>
                <x-text-input id="password" class="block mt-1 w-full form-text-input form-item"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800 form-item form-label" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400 form-label">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="form-item password-link underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3 form-button-input form-item">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</div>
