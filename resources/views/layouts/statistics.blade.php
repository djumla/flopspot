@extends("layouts.headLayout")

@section('body')
  <div id="app">
    <header class="wrapper">
      <a href="/"> <img src="/assets/logo_rgb_inverted_dark.svg"/></a>
      <nav>
        <ul>
          <li><a id="home" href="/">Startseite</a></li>
          <li><a class="active" id="statistic" href="/statistic">Statistiken</a></li>
        </ul>
      </nav>
    </header>
    <flopspot-overall></flopspot-overall>
    <flopspot-footer></flopspot-footer>
  </div>
  <script src="{{ asset('js/statistics.js') }}"></script>
@endsection