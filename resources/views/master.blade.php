<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Daily Journal') }}@hasSection('title') - @yield('title') @endif</title>

    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-nKUxD..." crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            font-family: "Bai Jamjuree", sans-serif;
            letter-spacing: 0.2px;
        }

        body {
            background: #f4f6f9;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #d7d7d7;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }


        /* Navbar มินิมอล */
        .navbar {
            background: #ffffff !important;
            border-bottom: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.3rem;
            color: #333 !important;
        }

        .nav-link {
            color: #666 !important;
            font-weight: 400;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
        }

        .nav-link:hover {
            background: #f1f3f5;
            color: #000 !important;
        }

        .nav-link.active {
            background: #e9ecef;
            color: #000 !important;
        }

        /* Dropdown */
        .dropdown-menu {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .dropdown-item:hover {
            background: #f1f3f5;
        }

        /* Container */
        .container {
            max-width: 1050px;
        }

        /* Alert มินิมอล */
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.05);
        }
    </style>
    @yield('styles')
    @stack('styles')
</head>

<body>
    @include('layouts.navbar')

    <main class="py-4">
        <div class="container">
            @if (session('200'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('200') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
    @stack('scripts')
</body>

</html>

