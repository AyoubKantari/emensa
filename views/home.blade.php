@extends('layouts.main')

@section('title', 'E-Mensa - Startseite')

@section('content')
    <!-- Platzhalter für Bild/Banner -->
    <div class="square"></div>

    <!-- Ankündigung -->
    <section id="ank">
        <h2 id="ank_schrift">Bald gibt es Essen auch online ;)</h2>
        <p id="ank_Beschreibung">
            Wir arbeiten derzeit daran, Essen online verfügbar zu machen.
            Bald können Sie bequem von zu Hause aus bestellen!
        </p>
    </section>

    <!-- Speisen -->
    <section id="speizen">
        <h2 id="speizen_schrift">Köstlichkeiten, die Sie erwarten</h2>
        <p><strong>Anzahl verfügbarer Gerichte:</strong> {{ $anzahl }}</p>

        @if(count($gerichte) > 0)
            <table id="tabelle">
                <thead>
                <tr>
                    <th>Bild</th>
                    <th>Gericht</th>
                    <th>Beschreibung</th>
                    <th>Preis intern</th>
                    <th>Preis extern</th>
                    <th>Allergene</th>
                </tr>
                </thead>
                <tbody>
                @foreach($gerichte as $gericht)
                        <?php
                        $bildpfad = '/img/gerichte/';
                        $bildDatei = $gericht['bildname'];
                        if ($bildDatei && file_exists($_SERVER['DOCUMENT_ROOT'] . $bildpfad . $bildDatei)) {
                            $bildUrl = $bildpfad . $bildDatei;
                        } else {
                            $bildUrl = $bildpfad . '00_image_missing.jpg';
                        }
                        ?>
                    <tr>
                        <td>
                            <img src="{{ $bildUrl }}" alt="{{ $gericht['name'] }}" width="100" height="75" style="object-fit: cover; border-radius: 4px;">
                        </td>
                        <td>{{ $gericht['name'] }}</td>
                        <td>{{ $gericht['beschreibung'] ?? '-' }}</td>
                        <td>{{ number_format($gericht['preisintern'], 2, ',', '.') }} €</td>
                        <td>{{ number_format($gericht['preisextern'], 2, ',', '.') }} €</td>
                        <td>
                            @if(!empty($gericht['allergene']))
                                {{ implode(', ', $gericht['allergene']) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>

    <!-- Wichtig für uns -->
    <section id="wichtig">
        <h2 id="speizen_schrift">Das ist uns wichtig</h2>
        <ul>
            <li>Beste frische saisonale Zutaten</li>
            <li>Ausgewogene abwechslungsreiche Gerichte</li>
            <li>Sauberkeit</li>
        </ul>
        <h3 id="feun">Wir freuen uns auf Ihren Besuch!</h3>
    </section>
@endsection
