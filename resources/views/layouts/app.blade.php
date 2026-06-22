<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mini Issue Tracker')</title>
    <style>
        body {
            margin: 0;
            background: #f6f7f9;
            color: #1f2937;
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px;
        }

        .alert {
            border-radius: 6px;
            margin-bottom: 20px;
            padding: 14px 16px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            color: #166534;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <main class="container">
        @include('partials.errors')

        @yield('content')
    </main>
</body>
</html>
