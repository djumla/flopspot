@extends("layouts.basicHtmlLayout")

@section('body')
    <div id="app">
        <header class="wrapper">
            <a href="/"> <img src="/assets/logo_rgb_inverted_dark.svg"/></a>
            <nav>
                <ul>
                    <li><a class="active" id="home" href="/">Startseite</a></li>
                    <li><a id="statistic" href="/statistic">Statistiken</a></li>
                </ul>
            </nav>
        </header>
        <flopspot-form></flopspot-form>
        <flopspot-article></flopspot-article>
        <flopspot-footer></flopspot-footer>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"> </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/responsive.js"></script>
    <script src="js/observer.js"></script>
@endsection
