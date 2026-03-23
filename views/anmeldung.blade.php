@extends('layouts.main')

@section('title', 'Anmeldung')

@section('content')
    <div class="login-card">
        <h1>Anmeldung</h1>

        @if($fehler)
            <div class="login-error">{{ $fehler }}</div>
        @endif

        <form action="/anmeldung_verifizieren" method="POST">
            <div class="form-group">
                <label for="email">E-Mail:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    placeholder="max@example.com"
                >
            </div>

            <div class="form-group">
                <label for="passwort">Passwort:</label>
                <input
                    type="password"
                    id="passwort"
                    name="passwort"
                    required
                    placeholder="••••••••"
                >
            </div>

            <button type="submit" style="width: 100%; padding: 10px; font-size: 1rem;">
                Anmelden
            </button>
        </form>

        <p class="login-back">
            <a href="/">Zurück zur Startseite</a>
        </p>
    </div>
@endsection
