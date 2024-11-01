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

<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo"></x-slot>


        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <div class="full-form">
            <h1 class="form-header">YCL</h1>
            <hr class="line">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-label for="name" :value="__('Name')" class="form-item form-label" />

                    <x-input id="name" class="block mt-1 w-full form-text-input form-item" type="text" name="name" :value="old('name')" required autofocus />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-label for="email" :value="__('Email')" class="form-item form-label" />

                    <x-input id="email" class="block mt-1 w-full form-text-input form-item" type="email" name="email" :value="old('email')" required />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" :value="__('Password')" class="form-item form-label" />

                    <x-input id="password" class="block mt-1 w-full form-text-input form-item"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" class="form-item form-label" />

                    <x-input id="password_confirmation" class="block mt-1 w-full form-text-input form-item"
                                    type="password"
                                    name="password_confirmation" required />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 form-item password-link" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-button class="ml-4 form-button-input form-item">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
