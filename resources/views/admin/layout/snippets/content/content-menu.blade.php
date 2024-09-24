{{--<div class="content-menu">--}}
{{--    <div class="page-menu-icon-w">--}}
{{--        <i class="fas fa-home"></i>--}}
{{--    </div>--}}

{{--    <div class="page-menu-content">--}}
{{--        <div class="pmc-left">--}}
{{--            <div class="pmc-left-content">--}}
{{--                <h1> {{ __('Dashboard - All in one ') }} </h1>--}}
{{--                <div class="pmc-lc-breadcrumbs">--}}
{{--                    <a href="#">--}}
{{--                        <i class="fas fa-home"></i>--}}
{{--                        <p>{{ __('Dashboard') }}</p>--}}
{{--                    </a>--}}
{{--                    /--}}
{{--                    <a href="#">{{ __('Analytics') }}</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="pmc-right">--}}
{{--            <div class="pmc-right-content">--}}
{{--                <a href="#">--}}
{{--                    <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>--}}
{{--                </a>--}}
{{--                <a href="#">--}}
{{--                    <button class="pm-btn btn pm-btn-success">--}}
{{--                        <i class="fas fa-plus"></i>--}}
{{--                        <span>{{ __('Create New') }}</span>--}}
{{--                    </button>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


<div class="content-menu">
    <div class="page-menu-icon-w">
        @yield('c-icon')
    </div>

    <div class="page-menu-content">
        <div class="pmc-left">
            <div class="pmc-left-content">
                <h1> @yield('c-title') </h1>
                <div class="pmc-lc-breadcrumbs">
                    @yield('c-breadcrumbs')
                </div>
            </div>
        </div>

        <div class="pmc-right">
            <div class="pmc-right-content">
                @yield('c-buttons')
            </div>
        </div>
    </div>
</div>
