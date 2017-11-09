@extends("layouts.layout")

@section("body")
    <div id="app">
        <app-header></app-header>
        @yield("content")
        <app-footer></app-footer>
    </div>
    <script src="{{ asset('js/layout.js') }}"></script>
@endsection