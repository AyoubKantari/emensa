<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kategorien</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #333; }
        .fett { font-weight: bold; }
        p { padding: 10px; margin: 5px 0; background: #f9f9f9; border-left: 3px solid #4CAF50; }
        a { display: inline-block; margin-top: 20px; padding: 10px 15px; background: #4CAF50; color: white; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>
<h1>Aufgabe 7b - Kategorien</h1>
<p><em>Kategorien aufsteigend sortiert, jede zweite fett</em></p>
@foreach($kategorien as $kategorie)
    <p class="{{ !$loop->even ? 'fett' : '' }}">{{ $kategorie['name'] }}</p>
@endforeach
<a href="/">Zurück zur Hauptseite</a>
</body>
</html>
