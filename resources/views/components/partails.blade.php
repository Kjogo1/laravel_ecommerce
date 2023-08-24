<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping</title>
    <link href="../../css/style.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @if (Session::has('message'))
        <div class="flex justify-end">
            <p class="bg-green-500 rounded-lg text-white p-2 px-20">{{ Session::get('message') }}</p>
        </div>
    @endif
    @yield('content')
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script> --}}
</body>

</html>
