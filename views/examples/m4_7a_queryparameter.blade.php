<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Query Parameter</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .result { background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 20px 0; }
        a { display: inline-block; margin: 5px 10px 5px 0; padding: 10px 15px; background: #4CAF50; color: white; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>
<h1>Aufgabe 7a - Query Parameter</h1>
<div class="result">
    <p>Der Wert von name lautet: {{ $name }}</p>
</div>
<h3>Teste verschiedene Werte:</h3>
<a href="/m4_7a_queryparameter?name=Aymen">Test mit Aymen</a>
<a href="/m4_7a_queryparameter?name=Radi">Test mit Radi</a>
<a href="/m4_7a_queryparameter?name=Ayoub">Test mit Ayoub</a>
<a href="/m4_7a_queryparameter">Ohne Parameter</a>
<p><a href="/">Zurück zur Hauptseite</a></p>
</body>
</html>
