@extends("layouts.headLayout")

@section("body")
    <div id="app">
        <header class="wrapper">
            <img src="/assets/logo_rgb_inverted_dark.svg"></img>
            <nav>
                <ul>
                    <li><a id="home" href="/">Startseite</a></li>
                    <li><a id="statistic" href="/statistic">Statistiken</a></li>
                </ul>
            </nav>
        </header>
        @yield("content")
        <flopspot-footer></flopspot-footer>
    </div>
    <script src="{{ asset('js/layout.js') }}"></script>
@endsection