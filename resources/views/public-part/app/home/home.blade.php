@extends('public-part.layout.layout')

@section('public-content')
    <div class="menu__wrapper">
        <div class="search__area">
            <input type="text" class="city" name="city" placeholder="{{ __('Sarajevo..') }}">
        </div>
        <div class="popular__cities">
            @foreach($popularCities as $city)
                <div class="popular_city">
                    <div class="city"><p>{{ $city->name ?? '' }}</p></div>
                    <div class="weather_icon">
                        <img src="https://www.accuweather.com/images/weathericons/{{ $city->twelveHoursCurrentRel->icon ?? '1' }}.svg" alt="{{ __('Weather icon') }}">
                    </div>
                    <div class="temperature"> <p> {{ $city->currentTemperature() }} </p> </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="main__wrapper">
        <div class="main__layer">
            <div class="data__layer">
                <div class="info__wrapper">
                    <div class="header">
                        <h5>{{ __('Sarajevo, Federation of Bosnia and Herzegovina') }}</h5>
                        <p>20:06</p>
                    </div>
                    <div class="temperature__wrapper">
                        <div class="img__wrapper">
                            <img src="https://www.accuweather.com/images/weathericons/36.svg" alt="{{ __('Weather icon') }}">
                        </div>
                        <div class="temp__wrapper">
                            <h1>4°C</h1>
                        </div>
                        <div class="info__inner_wrapper">
                            <div class="ii_i_w">
                                <h6>Cloudy</h6>
                                <p>Feels like 5°C</p>
                            </div>
                        </div>
                    </div>
                    <div class="text__wrapper">
                        <p>{{ __('Najniža temperatura -3°C, najviša 7°C') }}</p>
                    </div>
                    <div class="other__info">
                        <div class="oi_w">
                            <p>{{ __('Kvalitet zraka') }}</p>
                            <h5>24</h5>
                        </div>
                        <div class="oi_w">
                            <p>{{ __('Vjetar') }}</p>
                            <h5>15 km/h</h5>
                        </div>
                        <div class="oi_w">
                            <p>{{ __('Vlažnost') }}</p>
                            <h5>30%</h5>
                        </div>
                        <div class="oi_w">
                            <p>{{ __('Vidljivost') }}</p>
                            <h5>12km</h5>
                        </div>
                        <div class="oi_w">
                            <p>{{ __('Tačka orošavanja') }}</p>
                            <h5>-1.3°C</h5>
                        </div>
                    </div>
                </div>
                <div class="map__wrapper" id="map__wrapper"></div>
            </div>
            <div class="commercials__layer">
                <div class="img__wrapper">
                    <img src="{{ asset('files/images/commercials/office.png') }}" alt="">
                </div>
                <div class="text__wrapper">
                    <h4>{{ __('Upgrade to Office 2024 (Get Now)') }}</h4>
                    <a href="#">{{ __('Click here') }}</a>
                </div>
            </div>
        </div>

        <div class="daily__layer">
            <div class="forecast__wrapper">
                <div class="fw__header">
                    <h6>{{ __('Vremenska prognoza') }}</h6>
                    <div class="btns__w">
                        <button class="active">{{ __('12 sati') }}</button>
                        <button>{{ __('5 dana') }}</button>
                    </div>
                </div>
                <div class="fw__body">
                    @foreach($currentCity->twelveHoursRel as $forecast)
                        <div class="fw_b_row">
                            <div class="weather_info">
                                <img src="https://www.accuweather.com/images/weathericons/36.svg" alt="{{ __('Weather icon') }}">
                                <h6>{{ $forecast->temperature ?? '0' }}°C / {{ $forecast->temperature_rf }}°C</h6>
                            </div>
                            <div class="date">
                                <p>{{ $forecast->getDayAndTime() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="summary_wrapper">

            </div>
        </div>
    </div>
@endsection
