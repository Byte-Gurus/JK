
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JK STORE</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
   
    
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body>
    {{ $slot }}
    
    @vite('resources/js/app.js')
    @livewireScripts()
</body>
</html>