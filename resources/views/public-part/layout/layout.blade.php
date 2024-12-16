<html>
    <head>
        <title> @yield('title', 'Web App') </title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('files/images/public-part/logo.svg') }}" />
        <link href="//fastly-cloud.typenetwork.com/projects/7921/fontface.css?660e9b3f" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Meta tags -->
        @include('public-part.layout.snippets.meta-tags')

        @vite(['resources/css/public-part/layout.scss', 'resources/js/app.js'])
        @yield('js-scripts')
    </head>

    <body>
        <!-- Right menu -->
        @if(!isset($hideMenu))
            @include('public-part.layout.snippets.right-menu')
        @endif
        <!-- Public content wrapper should be used in every public page -->
        <div class="public-content pt-0">
            <!-- Static element on every page -->
            @if(!isset($hideMenu))
                @include('public-part.layout.snippets.menu')
            @endif

            <!-- Yield data into it -->
            @yield('public-content')
        </div>

        <!-- Static element on every page -->
        @include('public-part.layout.snippets.footer')
    </body>
</html>
