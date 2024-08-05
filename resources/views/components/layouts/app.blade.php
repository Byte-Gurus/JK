<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JK STORE</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('build/assets/app-DJcDnJtG.css') }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">


    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('fa7d24aad8f58de38dcc', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('JK-Store');
        channel.bind('Testing', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
</head>

<body>
    {{ $slot }}


    @vite('resources/js/app.js')
    @livewireScripts()


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />

</body>

</html>
