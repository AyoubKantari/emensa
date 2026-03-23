@extends(".layouts.layout")

@section("cssextra")
    <link rel="stylesheet" href="css/intellij-light.css">
    <style>
        body > div {
            background-color: {{ '#' . $bgcolor }};
        }
        pre, pre code, code.hljs {
            white-space: pre;
            tab-size: 4;
            -moz-tab-size: 4;
        }
    </style>
@endsection

@section("jsextra")
    <script>hljs.highlightAll();</script>
@endsection

@section("content")
    <div>
        <h1>Demo für {{ $name }}</h1>
        <p>Kurze Übersicht, wie die Arbeit mit dem Router und der Blade View-Engine funktioniert.</p>
        <h2>Router</h2>
        <p>Der Router nimmt den Request entgegen und zerlegt ihn in die einzelnen Teile der URI.</p>
        @if(count($rd->args))
            <p><strong>Argumente dieses Aufrufs:</strong></p>
            @forelse($rd->args as $a)
                <div><span class="code">{{$a}}</span></div>
            @empty
                <p>Keine weiteren Argumente im Request</p>
            @endforelse
        @endif
        @if(count($rd->query))
            <p><strong>Daten aus der Query dieses Aufrufs:</strong></p>
            <pre><code class="language-php">
            @forelse($rd->query as $k => $v)
                        $rd->query['{{$k}}']={{$v}}
                    @empty
                        <p>Keine Querydaten</p>
                    @endforelse
            </code></pre>
        @endif
    </div>
@endsection
