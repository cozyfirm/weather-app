@extends('public-part.layout.layout')

@section('public-content')
    <div class="preview__wrapper">
        <div class="current__wrapper">
            <div class="header">
                <div class="city__">
                    <h2>{{ $city->name ?? '' }}</h2>
                    <h2 class="current">{{ __('trenutno') }}</h2>
                </div>
                <p class="datetime">{{ $dateTime }}</p>
            </div>
            <div class="temperature__wrapper">
                <div class="temperature__info">
                    <h4>{{ $city->twelveHoursCurrentRel->phase ?? '' }}</h4>
                </div>
                <div class="temperature__iww">
                    <div class="info__wrapper">
                        <div class="main__info__w">
                            <div class="miw__temp">
                                <div class="img__wrapper">
                                    <img src="{{ asset('files/images/weathericons/' . ( $city->twelveHoursCurrentRel->icon ?? '1' ) . '.png') }}" alt="{{ __('Weather icon') }}">
                                </div>
                                <div class="temp__wrapper">
                                    <h1>{{ temperatureHelper::roundUp($city->twelveHoursCurrentRel->temperature ?? '0') }}°C</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="real__feel__mobile">
                        <h5>{{ __('Realan osjećaj') }} {{ temperatureHelper::roundUp($city->twelveHoursCurrentRel->temperature_rf ?? '0') }} °C </h5>
                    </div>

                    <div class="other__info__wrapper">
                        <div class="oiw__info yellow-warning">
                            <p>{{ __('Žuto upozorenje za maglu 00:00 - 11:00h') }}</p>
                        </div>
                        <div class="oiw__info info-warning">
                            <p>{{ __('Srijeda navečer snijeg 20:00 - 23:59') }}</p>
                        </div>

                        <!-- No warnings present -->
                        {{--                    <div class="oiw__info">--}}
                        {{--                        <p>{{ __('Nema aktuelnih upozorenja') }}</p>--}}
                        {{--                    </div>--}}
                    </div>
                </div>
            </div>
            <div class="other__info">
                <div class="other__info__temp" title="{{ $city->twelveHoursCurrentRel->temperature_desc ?? '' }}">
                    <h5>{{ __('Realan osjećaj') }} {{ temperatureHelper::roundUp($city->twelveHoursCurrentRel->temperature_rf ?? '0') }} °C </h5>
                </div>
                <div class="other__info__inner">
                    <div class="oi_w">
                        <p>{{ __('Vjetar') }}</p>
                        <h5>{{ $city->twelveHoursCurrentRel->wind_speed ?? '' }} km/h</h5>
                    </div>
                    <div class="oi_w">
                        <p>{{ __('Vlažnost') }}</p>
                        <h5>{{ $city->twelveHoursCurrentRel->rel_humidity ?? '' }}%</h5>
                    </div>
                    <div class="oi_w">
                        <p>{{ __('Vidljivost') }}</p>
                        <h5>{{ $city->twelveHoursCurrentRel->visibility ?? '' }}km</h5>
                    </div>
                    <div class="oi_w">
                        <p>{{ __('Tačka orošavanja') }}</p>
                        <h5>{{ $city->twelveHoursCurrentRel->dev_point ?? '' }}°C</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Twelve hours forecast -->
        <div class="twelve__hours__wrapper">
            <div class="swiper multi-swiper">
                <div class="swiper-wrapper">
                    @foreach($twelveHours as $tw)
                    <div class="swiper-slide transition-05 total-days">
                        <div class="inside-swiper active">
                            <p> {{ $tw->getTime() }} </p>
                            <img src="{{ asset('files/images/weathericons/' . ( $tw->icon ?? '1' ) . '.png') }}" alt="{{ __('Weather icon') }}">
                            <h5> @if($tw->icon == "sunrise") {{ __('Izlazak') }} @elseif($tw->icon == "sunset") {{ __('Zalazak') }} @else {{ temperatureHelper::roundUp($tw->temperature ?? '0') }}°C @endif</h5>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>

        <!-- Five days forecast -->
        @include('public-part.app.forecast.includes.five-days-forecast')

        <!-- Only on mobile version, show this data at before five days forecast -->
        <div class="mobile__additional_info">
            <div class="mai_w">
                <p>{{ __('Vjetar') }}</p>
                <h5>{{ $city->twelveHoursCurrentRel->wind_speed ?? '' }} km/h</h5>
            </div>
            <div class="mai_w">
                <p>{{ __('Vlažnost') }}</p>
                <h5>{{ $city->twelveHoursCurrentRel->rel_humidity ?? '' }}%</h5>
            </div>
            <div class="mai_w">
                <p>{{ __('Vidljivost') }}</p>
                <h5>{{ $city->twelveHoursCurrentRel->visibility ?? '' }}km</h5>
            </div>
            <div class="mai_w">
                <p>{{ __('Tačka orošavanja') }}</p>
                <h5>{{ $city->twelveHoursCurrentRel->dev_point ?? '' }}°C</h5>
            </div>
        </div>

        @include('public-part.app.forecast.includes.wind-direction')
    </div>
@endsection
