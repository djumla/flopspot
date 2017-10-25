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
    <script src="./js/responsive.js"></script>
  </head>
  <body>
    <div id="app">
      <flopspot-header></flopspot-header>
      <flopspot-pie></flopspot-pie>
      <flopspot-footer></flopspot-footer>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
  </body>
</html>
