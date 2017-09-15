<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>flopspot</title>
    <meta name="description" content="Description">
    <meta name="author" content="Sven Ahrens">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Noto+Sans|Noto+Serif|Open+Sans|Poppins" rel="stylesheet">

    <link rel="stylesheet" href="/css/styles.css" >

    <script src="node_modules/vue/dist/vue.js"></script>
    <script
    src="https://code.jquery.com/jquery-3.2.1.js"
    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"
    ></script>
    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"
    ></script>
    <script src="flopspot-responsive.js"></script>
    <script src="flopspot-observer.js"></script>
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
