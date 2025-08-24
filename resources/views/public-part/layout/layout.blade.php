<html>
    <head>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-MW3NVGXK');</script>
        <!-- End Google Tag Manager -->

        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3860319822168575" crossorigin="anonymous"></script>


        <title>@yield('title', 'vrijeme24.ba - Vremenska prognoza')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('files/images/favicon.png') }}" />
        <link href="//fastly-cloud.typenetwork.com/projects/7921/fontface.css?660e9b3f" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Meta tags -->
        @include('public-part.layout.snippets.meta-tags')

        @vite(['resources/css/public-part/layout.scss', 'resources/js/app.js'])
        @yield('js-scripts')
    </head>

    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MW3NVGXK" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->

        <!-- Right menu -->
        @if(!isset($hideMenu))
            @include('public-part.layout.snippets.right-menu')
        @endif

        <!-- Mobile search -->
        @include('public-part.layout.snippets.mobile-search')

        <!-- Public content wrapper should be used in every public page -->
        <div class="public-content pt-0 @isset($gap) gap-0 @endisset">
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
