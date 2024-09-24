<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <title> @yield('title') </title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('files/images/default/ekipa.png') }}"/>
    <link href="//fastly-cloud.typenetwork.com/projects/7921/fontface.css?660e9b3f" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/bccf934f7c.js" crossorigin="anonymous"></script>

    <!-- CSS files + fonts -->
    @vite(['resources/css/app.scss', 'resources/css/admin/admin.scss', 'resources/js/app.js'])
</head>
<body>
    <!-- Main loading bar -->
    <div class="loading-gif d-none">
        <img src="{{ asset('files/images/default/loading-cubes.gif') }}" alt="">
    </div>

    <!-- Yield content of pages -->
    @yield('content')
</body>
</html>
