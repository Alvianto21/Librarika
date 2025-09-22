<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Librarika | {{ $title }}</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css', 'resources/js/app.js')
</head>
<body class="h-full">
    <div class="min-h-full">
        <x-homes.header></x-homes.header>

        <!-- Main Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Flowbite Js -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    @stack('scripts')
</body>
</html>