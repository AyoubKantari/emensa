<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Gerichte über 2 EUR</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background-color: #4CAF50; color: white; padding: 12px; text-align: left; }
        td { border: 1px solid #ddd; padding: 10px; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        a { display: inline-block; margin-top: 20px; padding: 10px 15px; background: #4CAF50; color: white; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>
<h1>Aufgabe 7c - Gerichte über 2 EUR</h1>
<p><em>Gerichte mit Preis intern > 2 EUR, sortiert nach Name absteigend (Z-A)</em></p>
@if(count($gerichte) > 0)
    <table>
        <thead><tr><th>Name</th><th>Preis intern</th></tr></thead>
        <tbody>
        @foreach($gerichte as $gericht)
            <tr>
                <td>{{ $gericht['name'] }}</td>
                <td>{{ number_format($gericht['preisintern'], 2, ',', '.') }} EUR</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>Es sind keine Gerichte vorhanden</p>
@endif
<a href="/">Zurück zur Hauptseite</a>
</body>
</html>
