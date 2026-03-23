@extends(".layouts.layout")

@section("content")
    <div>
    @if (isset($data['error']))
        <h1>Problem beim Verbinden mit der Datenbank</h1>
        <p>Fehlermeldung {{$data['error']}}</p>
        <pre> {{$data['beschreibung']}}</pre>
    @else
    <article>
        <h1>Daten aus der Tabelle: Gerichte</h1>
        <ul class="list-unstyled">
            @forelse($data as $a)
                <li>{{$a['name']}}</li>
            @empty
                <li>Keine Daten vorhanden.</li>
            @endforelse
        </ul>
    </article>
    @endif
    </div>
@endsection
