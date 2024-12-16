@extends('public-part.layout.layout')

@section('public-content')
    <div class="search__wrapper">
        <div class="search__list">
            @for($i=0; $i<10; $i++)
                <div class="search__row">
                    <h5>Sarajevo</h5>
                    <p>Federacija Bosne i Hercegovine, Bosna i Hercegovina</p>
                </div>
            @endfor
        </div>
{{--        <div class="border__line"></div>--}}
        <div class="side__info">
            <div class="side__info__inner">
                <div class="si__header">
                    <h4>{{ __('ZADNJE PRETRAŽIVANO') }}</h4>
                </div>
                <div class="si__body">
                    <div class="si__b__row">
                        <p>Sarajevo</p>
                        <div class="weather__icon">
                            <p>-5°C</p>
                            <img src="https://www.accuweather.com/images/weathericons/18.svg" alt="{{ __('Weather icon') }}">
                        </div>
                    </div>
                    <div class="si__b__row">
                        <p>Mostar</p>
                        <div class="weather__icon">
                            <p>12°C</p>
                            <img src="https://www.accuweather.com/images/weathericons/17.svg" alt="{{ __('Weather icon') }}">
                        </div>
                    </div>
                    <div class="si__b__row">
                        <p>Bjeljina</p>
                        <div class="weather__icon">
                            <p>8°C</p>
                            <img src="https://www.accuweather.com/images/weathericons/12.svg" alt="{{ __('Weather icon') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="side__info__inner">
                <div class="si__header">
                    <h4>{{ __('POPULARNO') }}</h4>
                </div>
                <div class="si__body">
                    <div class="si__b__row">
                        <p>Sarajevo</p>
                        <div class="weather__icon">
                            <p>-5°C</p>
                            <img src="https://www.accuweather.com/images/weathericons/18.svg" alt="{{ __('Weather icon') }}">
                        </div>
                    </div>
                    <div class="si__b__row">
                        <p>Mostar</p>
                        <div class="weather__icon">
                            <p>12°C</p>
                            <img src="https://www.accuweather.com/images/weathericons/17.svg" alt="{{ __('Weather icon') }}">
                        </div>
                    </div>
                    <div class="si__b__row">
                        <p>Bjeljina</p>
                        <div class="weather__icon">
                            <p>8°C</p>
                            <img src="https://www.accuweather.com/images/weathericons/12.svg" alt="{{ __('Weather icon') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
