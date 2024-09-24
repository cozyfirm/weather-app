<html>
    <head>
        <title>{{ 'Welcome' }}</title>
        <script src="https://kit.fontawesome.com/bccf934f7c.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('files/images/public-part/logo.svg') }}" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">


        @vite(['resources/css/app.scss', 'resources/css/admin/admin.scss', 'resources/js/app.js'])
    </head>
    <body>
        @include('admin.layout.snippets.menu')

        <!-- Main page content -->
        <div class="main-content">
            <!-- Basic header of every page -->
            @include("admin.layout.snippets.content.content-menu")

            <!-- Main content of every page -->
            @yield('content')
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"> </script>
        <script>

            $('.summernote').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    // ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', ]], // 'picture', 'video'
                    ['view', ['help']],
                    ['height', ['height']],
                ],
                placeholder: 'Unesite vaš tekst ovdje ..',
                height : 300
            });

            if ( $('.summernote').is('[readonly]') ) {
                $('.summernote').summernote('disable');
            }

        </script>
    </body>
</html>
