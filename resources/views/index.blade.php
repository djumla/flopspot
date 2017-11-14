@extends("layouts.headLayout")

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
    <flopspot-service></flopspot-service>
    <flopspot-footer></flopspot-footer>
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
  <script
          src="https://code.jquery.com/jquery-3.2.1.js"
          integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
          crossorigin="anonymous"
  ></script>
  <script src="js/responsive.js"></script>
  <script src="js/observer.js"></script>
@endsection
