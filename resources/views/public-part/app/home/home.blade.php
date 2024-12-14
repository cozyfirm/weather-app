@extends('public-part.layout.layout')

@section('public-content')
    <div class="top__menu_wrapper">
        <div class="inner__menu__wrapper">
            <div class="logo_wrapper">
                <img src="{{ asset('files/images/logo.png') }}" alt="">
            </div>
            <div class="hamburger__wrapper">
                <img src="{{ asset('files/images/icons/bars-solid.svg') }}" alt="">
            </div>
        </div>
    </div>

    <div class="homepage__wrapper">
        <div class="inner__wrapper">
            <div class="search__upper_description">
                <h2>{{ __('Pouzdana prognoza') }}</h2>
            </div>

            <div class="search__wrapper">
                <div class="search__bar">
                    <div class="default__bar">
                        <div class="icon__wrapper">
                            <img src="{{ asset('files/images/icons/search-white.svg') }}" alt="">
                        </div>
                        <div class="input__wrapper">
                            <input type="text" name="search" id="main-search" placeholder="{{ __('Unesi svoju lokaciju') }}">
                        </div>
                    </div>
                    <div class="dropdown__wrapper d-none">
                        <div class="searched__values">
                            <div class="search_row">
                                <h3>Sarajevo</h3>
                            </div>
                            <div class="search_row">
                                <h3>Tuzla</h3>
                            </div>
                            <div class="search_row">
                                <h3>Mostar</h3>
                            </div>
                        </div>

                        <hr>

                        <div class="default__values">
                            <div class="popular__search">
                                <p>Sarajevo</p>
                                <span>|</span>
                                <p>Tuzla</p>
                                <span>|</span>
                                <p>Zenica</p>
                            </div>
                            <div class="current__location">
                                <img src="{{ asset('files/images/icons/location-arrow.svg') }}" alt="">
                                <p>{{ __('Koristi trenutnu lokaciju') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular and searched locations -->
            <div class="popular_n_searched_locations_w">
                <!-- Default popular locations -->
                <div class="popular__locations">
                    <div class="popular__dropdown">
                        <h4>{{ __('Popularne lokacije') }}</h4>
                        <img src="{{ asset('files/images/icons/arrow-down.svg') }}" alt="">
                    </div>

                    <div class="popular__locations__map" id="map__wrapper"></div>
                </div>

                <!-- Previous locations and banner -->
                <div class="previous__locations__wrapper">
                    <div class="previous__locations">
                        <div class="pl__header">
                            <h3>{{ __('Ranije lokacije') }}</h3>
                        </div>
                        <div class="pl__body">
                            @for($i=0; $i<4; $i++)
                                <div class="pl_b_row">
                                    <p>Sarajevo</p>
                                    <div class="icons__wrapper">
                                        <div class="temp__wrapper">
                                            8° | 16 °C
                                        </div>
                                        <img src="https://www.accuweather.com/images/weathericons/1.svg" alt="{{ __('Weather icon') }}">
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="banner__wrapper">
                        <img src="{{ asset('files/images/icons/banner.png') }}" alt="">
                    </div>
                </div>
            </div>

            <!-- Full banner -->
            <div class="full__banner">
                <img src="{{ asset('files/images/icons/banner.png') }}" alt="">
            </div>
        </div>
    </div>
@endsection
