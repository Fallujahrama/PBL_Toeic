<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'TOEIC Center Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons (CDN) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Nucleo Icons (CDN) -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- Argon Dashboard CSS (CDN) -->
    <link href="https://demos.creative-tim.com/argon-dashboard/assets/css/argon-dashboard.min.css?v=2.0.4" rel="stylesheet" />

    <!-- SweetAlert2 (CDN Bootstrap Theme) -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5/bootstrap-4.min.css" rel="stylesheet">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    @stack('css')
</head>

<body class="g-sidenav-show bg-gray-100">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <main class="main-content position-relative border-radius-lg">
        <!-- Navbar -->
        @include('layouts.navbar')

        <div class="container-fluid py-4">
            @yield('content')

            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </main>

    <!-- JS Libraries (CDN) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Fix for Argon Dashboard JS -->
    <script>
        // Safely initialize Argon Dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS animations
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
            
            // CSRF Token for AJAX Requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    <!-- Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>

    @stack('js')
</body>

</html>
