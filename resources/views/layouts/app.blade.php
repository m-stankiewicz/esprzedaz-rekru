<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PetStore')</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('includes.navbar')
    <main class="container mx-auto mt-4">
        @include('includes.alerts')
        @yield('content')
    </main>
</body>
</html>
