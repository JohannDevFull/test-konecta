<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> -->
        <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

        
        <!-- font-awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

        <style >
            body {
              font-size: .875rem;
            }

            .feather {
              width: 16px;
              height: 16px;
              vertical-align: text-bottom;
            }

            /*
             * Sidebar
             */

            .sidebar {
              position: fixed;
              top: 0;
              left: 0;
              bottom: 0;
              z-index: 100; /* Behind the navbar */
              padding: 48px 0 0; /* Height of navbar */
              box-shadow: inset 1px 0 0 rgba(0, 0, 0, .1);
            }

            @media (max-width: 767.98px) {
              .sidebar {
                top: 5rem;
              }
            }

            .sidebar-sticky {
              position: relative;
              top: 0;
              height: calc(100vh - 48px);
              padding-top: .5rem;
              overflow-x: hidden;
              overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
            }

            .sidebar .nav-link {
              font-weight: 500;
              color: #333;
            }

            .sidebar .nav-link .feather {
              margin-left: 4px;
              color: #727272;
            }

            .sidebar .nav-link.active {
              color: #2470dc;
            }

            .sidebar .nav-link:hover .feather,
            .sidebar .nav-link.active .feather {
              color: inherit;
            }

            .sidebar-heading {
              font-size: .75rem;
              text-transform: uppercase;
            }

            /*
             * Navbar
             */

            .navbar-brand {
              padding-top: .75rem;
              padding-bottom: .75rem;
              font-size: 1rem;
              background-color: rgba(0, 0, 0, .25);
              box-shadow: inset 1px 0 0 rgba(0, 0, 0, .25);
            }

            .navbar .navbar-toggler {
              top: .25rem;
              left: 1rem;
            }

            .navbar .form-control {
              padding: .75rem 1rem;
              border-width: 0;
              border-radius: 0;
            }

            .form-control-dark {
              color: #fff;
              background-color: rgba(255, 255, 255, .1);
              border-color: rgba(255, 255, 255, .1);
            }

            .form-control-dark:focus {
              border-color: transparent;
              box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
            }
        </style>
                
        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        @env ('local')
            <!-- <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script> -->
        @endenv

        <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
        </script>

        <!-- jQuery -->
        <script src="assets/admin-lte-v3.2.0/plugins/jquery/jquery.min.js"></script>

        <script src="assets/admin-lte-v3.2.0/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="assets/admin-lte-v3.2.0/plugins/jquery-validation/additional-methods.min.js"></script>
        
    </body>
</html>
