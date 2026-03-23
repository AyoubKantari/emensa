<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Mensa')</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header id="head">
    <div class="header-container">
        <div class="logo">E-Mensa Logo</div>
        <nav>
            <a href="/">Home</a>
            <a href="#speizen">Speisen</a>
            <a href="#Zahlen">Zahlen</a>
            <a href="#wichtig">Wichtig für uns</a>
            @if(isset($_SESSION['angemeldet']) && $_SESSION['angemeldet'])
                <span class="nav-user">
                    Angemeldet als:
                    <a href="/profil" class="nav-user">{{ $_SESSION['benutzer_name'] }}</a>
                </span>
                <a href="/abmeldung" class="nav-logout">Abmelden</a>
            @else
                <a href="/anmeldung" class="nav-login">Anmelden</a>
            @endif
        </nav>
    </div>
</header>
<div class="container">
    <main class="content">
        @yield('content')
    </main>
</div>
<footer id="footer">
    <div class="footer-container">
        <span>© E-Mensa GmbH</span>
        <span>|</span>
        <span>Ayoub Kantari, Aymen Radi</span>
        <span>|</span>
        <a href="#">Impressum</a>
    </div>
</footer>
</body>
</html>
