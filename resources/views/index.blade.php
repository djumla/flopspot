@extends('layouts.layout')

@section('scripts')
<script
src="https://code.jquery.com/jquery-3.2.1.js"
integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
crossorigin="anonymous"
></script>
<script src="./js/responsive.js"></script>
<script src="./js/observer.js"></script>
@endsection

@section('content')
<div id="app">
  <flopspot-header></flopspot-header>
  <flopspot-form></flopspot-form>
  <flopspot-service></flopspot-service>
  <flopspot-footer></flopspot-footer>
</div>
<!-- built files will be auto injected -->
<script src="{{ asset('js/app.js') }}"></script>
@endsection
