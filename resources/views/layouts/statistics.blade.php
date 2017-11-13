@extends("layouts.headLayout")

@section('scripts')
<script
src="https://code.jquery.com/jquery-3.2.1.js"
integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
crossorigin="anonymous"
></script>
@endsection

@section('body')
  <div id="app">
    <header class="wrapper">
      <img src="/assets/logo_rgb_inverted_dark.svg"></img>
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