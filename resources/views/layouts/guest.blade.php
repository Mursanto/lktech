<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="icon" type="image/png" href="{{ asset('images/LKtech.png') }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
        
        <!-- Boxicons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- Tailwind CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
            </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
