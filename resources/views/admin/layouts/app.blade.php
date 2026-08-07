<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Waima</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('fabicon/apple-touch-icon.png') }}">

<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('fabicon/favicon-32x32.png') }}">

<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('fabicon/favicon-16x16.png') }}">

    <link rel="manifest" href="{{ asset('images/site.webmanifest') }}">



    <!-- Bootstrap CSS -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">



    <!-- Custom CSS -->

    <link href="{{ asset('styles/style.css') }}" rel="stylesheet">



    @stack('styles')

</head>

<body class="bg-light">



    <!-- Main Container -->

    <div class="">

        @yield('content')

    </div>



    <!-- Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>

