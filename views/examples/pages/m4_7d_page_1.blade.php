@extends('examples.layout.m4_7d_layout')

@section('header')
    <h1>Seite 1 - Header</h1>
    <nav>
        <a href="/m4_7d_layout?no=1">Seite 1</a>
        <a href="/m4_7d_layout?no=2">Seite 2</a>
        <a href="/">Zurück zur Hauptseite</a>
    </nav>
@endsection

@section('main')
    <h2>Willkommen auf Seite 1</h2>
    <p>Dies ist der Hauptinhalt der ersten Seite.</p>
    <ul>
        <li>Einfaches Design</li>
        <li>Übersichtliche Struktur</li>
        <li>Klare Navigation</li>
    </ul>
@endsection

@section('footer')
    <p>2024 E-Mensa - Seite 1</p>
    <p>Ayoub Kantari, Aymen Radi</p>
@endsection
