@extends("layouts.headLayout")

@section("body")
    <div id="app">
        <flopspot-header></flopspot-header>
        @yield("content")
        <flopspot-footer></flopspot-footer>
    </div>
    <script src="{{ asset('js/layout.js') }}"></script>
@endsection