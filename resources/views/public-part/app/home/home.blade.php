@extends('public-part.layout.layout')

@section('title'){{ __('Vremenska prognoza za BiH | Vrijeme24.ba – Brzo, Pouzdano, Lokalno') }}@endsection
<!-- Meta tags -->
@section('meta_title'){{ __('Vremenska prognoza za BiH | Vrijeme24.ba – Brzo, Pouzdano, Lokalno') }}@endsection
@section('meta_desc'){{ __('Vrijeme u BiH – najnovija vremenska prognoza za danas, sutra i narednih 7 dana. Detaljno po gradovima: Sarajevo, Tuzla, Mostar, Banja Luka, Bihać, Zenica i drugi.') }}@endsection

@section('public-content')
    <div class="homepage__wrapper">
        <div class="inner__wrapper">
            <div class="main__search__wrapper">
                <div class="search__upper_description">
                    <img src="{{ asset('files/images/logo.png') }}" alt="{{ __('Vrijeme24.ba logo') }}">
                    <h1>{{ __('Pouzdana prognoza') }}</h1>
                </div>

                <div class="outside__search__wrapper">
                    <div class="search__title">
                        <h1>{{ __('Pouzdana prognoza') }}</h1>
                    </div>
                    <div class="search__wrapper">
                        <div class="search__bar">
                            <div class="default__bar">
                                <div class="icon__wrapper">
                                    <img src="{{ asset('files/images/icons/search-white.svg') }}" alt="">
                                </div>
                                <div class="input__wrapper">
                                    <input type="text" name="search" id="main-search" uri="{{ route('public.forecast.api-routes.search-by-text') }}" class="skip-home" placeholder="{{ __('Unesi svoju lokaciju') }}">
                                </div>
                            </div>
{{--                            <div class="dropdown__wrapper d-none">--}}
{{--                                <!-- Search items created in JS -->--}}

{{--                                <!-- Popular cities search -->--}}
{{--                                <div class="default__values">--}}
{{--                                    <div class="popular__search">--}}
{{--                                        @php $i = 0 @endphp--}}
{{--                                        @foreach($popular as $city)--}}
{{--                                            <p><a href="{{ route('public.forecast.preview', ['cityKey' => $city->key ?? 0]) }}" class="skip-home">{{ $city->name ?? '' }}</a></p>--}}
{{--                                            @if($i++ != 5) <span>|</span> @endif--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                    <div class="current__location skip-home">--}}
{{--                                        <img src="{{ asset('files/images/icons/location-arrow.svg') }}" alt="">--}}
{{--                                        <p>{{ __('Koristi trenutnu lokaciju') }}</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>

                    <div class="dropdown__wrapper d-none">
                        <!-- Search items created in JS -->

                        <!-- Popular cities search -->
                        <div class="default__values">
                            <div class="popular__search">
                                @php $i = 0 @endphp
                                @foreach($popular as $city)
                                    <p><a href="{{ route('public.forecast.preview', ['cityKey' => $city->key ?? 0]) }}" class="skip-home">{{ $city->name ?? '' }}</a></p>
                                    @if($i++ != 5) <span>|</span> @endif
                                @endforeach
                            </div>
                            <div class="current__location skip-home hover-pointer go-to-current-location" title="{{ __('Vremenska prognoza za Vašu trenutnu lokaciju') }}">
                                <img src="{{ asset('files/images/icons/location-arrow.svg') }}" alt="">
                                <p>{{ __('Koristi trenutnu lokaciju') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="popular_locations__home_wrapper">
                <div class="popular__dropdown">
                    <div class="inside__popular__dropdown noselect">
                        <h2>{{ __('Popularne lokacije') }}</h2>
                    </div>

                    <div class="popular__content">
                        @foreach($popular as $sample)
                            <a href="{{ route('public.forecast.preview', ['cityKey' => $sample->key ]) }}">
                                <div class="ppl_b_row">
                                    <h3>{{ $sample->name ?? '' }}</h3>
                                    <div class="ppl_icons__wrapper">
                                        <div class="temp__wrapper">
                                            {{ temperatureHelper::roundUp($sample->twelveHoursCurrentRel->temperature ?? '0') }}°C
                                        </div>
                                        <img src="{{ asset('files/images/weathericons/' . ( $sample->twelveHoursCurrentRel->icon ?? '') . '.png') }}" alt="{{ __('Weather icon') }}">
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

{{--                <!-- Full banner -->--}}
{{--                <div class="full__banner">--}}
{{--                    <img src="{{ asset('files/images/icons/banner.png') }}" alt="">--}}
{{--                </div>--}}
            </div>

            <!-- Popular and searched locations -->
            <div class="popular_n_searched_locations_w d-none">
                <!-- Default popular locations -->
                <div class="popular__locations">
                    <div class="popular__dropdown">
                        <div class="inside__popular__dropdown noselect">
                            <h4>{{ __('Popularne lokacije') }}</h4>
                            <img src="{{ asset('files/images/icons/arrow-down.svg') }}" alt="">
                        </div>

                        <div class="popular__content">
                            @foreach($popular as $sample)
                                <a href="{{ route('public.forecast.preview', ['cityKey' => $sample->key ]) }}">
                                    <div class="ppl_b_row">
                                        <p>{{ $sample->name ?? '' }}</p>
                                        <div class="ppl_icons__wrapper">
                                            <div class="temp__wrapper">
                                                {{ temperatureHelper::roundUp($sample->twelveHoursCurrentRel->temperature ?? '0') }}°C
                                            </div>
                                            <img src="{{ asset('files/images/weathericons/' . ( $sample->twelveHoursCurrentRel->icon ?? '') . '.png') }}" alt="{{ __('Weather icon') }}">
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="popular__locations__map" id="map__wrapper"></div>
                </div>

                <!-- Previous locations and banner -->
                <div class="previous__locations__wrapper">
                    @if($history->count())
                        <div class="previous__locations">
                            <div class="pl__header">
                                <h3>{{ __('Ranije pretrage') }}</h3>
                            </div>
                            <div class="pl__body">
                                @foreach($history as $sample)
                                    <a href="{{ route('public.forecast.preview', ['cityKey' => $sample->cityRel->key ]) }}">
                                        <div class="pl_b_row">
                                            <p>{{ $sample->cityRel->name ?? '' }}</p>
                                            <div class="icons__wrapper">
                                                <div class="temp__wrapper">
                                                    {{ temperatureHelper::roundUp($sample->cityRel->twelveHoursCurrentRel->temperature ?? '0') }}°C
                                                </div>
                                                <img src="https://www.accuweather.com/images/weathericons/{{ $sample->cityRel->twelveHoursCurrentRel->icon ?? '' }}.svg" alt="{{ __('Weather icon') }}">
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

{{--                    <div class="banner__wrapper">--}}
{{--                        <img src="{{ asset('files/images/icons/banner.png') }}" alt="">--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
