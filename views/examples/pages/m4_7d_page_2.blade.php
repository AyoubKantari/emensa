@extends('examples.layout.m4_7d_layout')

@section('header')
    <h1>Seite 2 - Header</h1>
    <nav>
        <a href="/m4_7d_layout?no=1">Seite 1</a>
        <a href="/m4_7d_layout?no=2">Seite 2</a>
        <a href="/">Zurück zur Hauptseite</a>
    </nav>
@endsection

@section('main')
    <h2>Willkommen auf Seite 2</h2>
    <p>Dies ist der Hauptinhalt der zweiten Seite.</p>
    <table style="width: 100%; background: white; border-collapse: collapse; margin-top: 20px;">
        <thead>
        <tr style="background: #667eea; color: white;">
            <th style="padding: 10px; text-align: left;">Vorname</th>
            <th style="padding: 10px; text-align: left;">Nachname</th>
        </tr>
        </thead>
        <tbody>
        <tr><td>Aymane</td><td>Radi</td></tr>
        <tr style="background: #f9f9f9;"><td>Ayoub</td><td>Kantari</td></tr>
        </tbody>
    </table>
@endsection

@section('footer')
    <p>2024 E-Mensa - Seite 2</p>
    <p>Kontakt: info@emensa.de</p>
@endsection
