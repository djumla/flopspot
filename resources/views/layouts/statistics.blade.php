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
    <script src="./js/flopspot-responsive.js"></script>
    <script src="./js/flopspot-observer.js"></script>
  </head>
  <body>
    <div id="app">
      <app-header></app-header>
      <app-overall></app-overall>
      <app-footer></app-footer>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
  </body>
</html>
