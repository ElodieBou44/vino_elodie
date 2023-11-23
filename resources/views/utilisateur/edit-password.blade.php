@extends('layouts.app')
@section("title", "Modification mot de passe")
@section('content')
<header >
        <a href="{{ route('profil.show', $user->id) }}" class="btn-arrow-top">
            <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
            </svg>
            profil
        </a>
</header>
<main class="form-border nav-margin">
    <h1 class="form-h1">
        Changer mot de passe
    </h1>
    <div class="form-container">
        <form method="post" id="edit-password">
            @csrf
            @method('put')
            <div class="form-input-container">
                <label for="oldPassword">Mot de passe actuel</label>
                <input type="password" id="oldPassword" name="oldPassword">
                @error('oldPassword')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-input-container">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-input-container">
                <label for="repeatNewPassword">Répéter mot de passe</label>
                <input type="password" id="repeatNewPassword" name="password_confirmation">
                @error('password_confirmation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-button">
                <button type="submit" form="edit-password" class="btn-submit">Mettre à jour</button>
            </div>
            <!-- Affichage des autres erreurs -->
            @if($errors->any())
                @foreach($errors->getMessages() as $key => $errorMessages)
                    @if(!in_array($key, ['oldPassword', 'password', 'password_confirmation']))
                        @foreach($errorMessages as $errorMessage)
                            <div class="error-message">{{ $errorMessage }}</div>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </form>
    </div>
</main>
@endsection