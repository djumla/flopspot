<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>flopspot</title>
    <meta name="description" content="Description">
    <meta name="author" content="Sven Ahrens">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Noto+Sans|Noto+Serif|Open+Sans|Poppins" rel="stylesheet">

    <link rel="stylesheet" href="/css/app.css" >

    <script
    src="https://code.jquery.com/jquery-3.2.1.js"
    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"
    ></script>
    <script src="flopspot-responsive.js"></script>
    <script src="flopspot-observer.js"></script>
    <script src="./vue2-autocomplete-js/dist/vue2-autocomplete.js"></script>
    <link rel="stylesheet" href="./vue2-autocomplete-js/dist/style/vue2-autocomplete.css">
  </head>
  <body>
    <div id="app">
      <app-header></app-header>
      <app-form></app-form>
      <app-service></app-service>
      <app-footer></app-footer>
    </div>
    <!-- built files will be auto injected -->
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
