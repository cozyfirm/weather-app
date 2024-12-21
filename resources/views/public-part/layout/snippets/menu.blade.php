<div class="top__menu_wrapper">
    <div class="inner__menu__wrapper">
        <div class="logo_wrapper">
            <a href="{{ route('public.home') }}">
                <img src="{{ asset('files/images/logo.png') }}" alt="">
            </a>
        </div>
        <div class="hamburger__and_search">
            <!-- Only visible on desktop version -->
            <div class="menu__search__wrapper ">
                <div class="icon__wrapper">
                    <img src="{{ asset('files/images/icons/search.svg') }}" alt="">
                </div>
                <div class="input__wrapper">
                    <input type="text" name="search" id="menu-search" class="menu-search" uri="{{ route('public.forecast.api-routes.search-by-text') }}" placeholder="{{ __('Unesi svoju lokaciju') }}">
                </div>
                <div class="searched__items__wrapper">
                    <div class="searched__items__inside">
                        <!-- Searched items; Written in JS -->

                        <!-- Previous search if exists -->
                        <div class="menu__last__search">
                            @foreach($history as $sample)
                                <a href="{{ route('public.forecast.preview', ['cityKey' => $sample->city_key ?? '0']) }}">
                                    <div class="last__search__row skip-closing">
                                        <div class="ls_r_data skip-closing">
                                            <h6 class="skip-closing">{{ $sample->cityRel->name ?? '' }}</h6>
                                            <p class="skip-closing">{{ $sample->cityRel->area ?? '' }}</p>
                                        </div>
                                        <div class="ls_r_info skip-closing">
                                            <img class="skip-closing" src="https://www.accuweather.com/images/weathericons/{{ $sample->cityRel->twelveHoursCurrentRel->icon ?? '' }}.svg" alt="{{ __('Weather icon') }}">
                                            <h4 class="skip-closing">{{ $sample->cityRel->twelveHoursCurrentRel->temperature ?? '' }}°C</h4>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="current__location">
                            <img src="{{ asset('files/images/icons/location-arrow.svg') }}" alt="">
                            <p>{{ __('Koristi trenutnu lokaciju') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile__search__trigger">
                <img src="{{ asset('files/images/icons/search-white.svg') }}" alt="">
            </div>
            <div class="hamburger__wrapper">
                <img src="{{ asset('files/images/icons/bars-solid.svg') }}" alt="">
            </div>
        </div>
    </div>
</div>
