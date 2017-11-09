@extends('layouts.layout')

@section('scripts')
<script
src="https://code.jquery.com/jquery-3.2.1.js"
integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
crossorigin="anonymous"
></script>
@endsection

@section('body')
  <div id="app">
    <flopspot-header></flopspot-header>
    <flopspot-pie></flopspot-pie>
    <flopspot-footer></flopspot-footer>
  </div>
  <script src="{{ asset('js/statistics.js') }}"></script>
@endsection
