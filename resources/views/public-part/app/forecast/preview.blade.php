@extends('public-part.layout.layout')

@section('title')Vremenska prognoza za {{ $city->getName() }} | Vrijeme24.ba @endsection
@section('meta_uri'){{ route('public.forecast.preview', ['cityKey' => $city->key ]) }}@endsection
{{--@section('meta_desc'){{ __("Vremenska prognoza za ") . $city->getName()  . __(". Trenutna temperatura iznosi ") . (temperatureHelper::roundUp($city->twelveHoursCurrentRel->temperature ?? '0')) . "°C." . " " . ($city->twelveHoursCurrentRel->phase ?? '')}}@endsection--}}
@section('meta_desc')Vremenska prognoza za {{ $city->getName() }}. Trenutna temperatura iznosi {{ temperatureHelper::roundUp($city->twelveHoursCurrentRel->temperature ?? '0') }}°C – {{ $city->twelveHoursCurrentRel->phase ?? '' }}. Detaljna prognoza za danas i narednih 5 dana. @endsection
@section('meta_img'){{ asset('files/images/weathericons/' . ( $city->twelveHoursCurrentRel->icon ?? '1' ) . '.png') }}@endsection
@section('meta_canonical'){{ route('public.forecast.preview-by-slug', ['slug' => $city->slug ?? 0]) }}@endsection

@section('public-content')
    <div class="preview__wrapper">
        <div class="current__wrapper">
            <div class="header">
                <div class="city__">
                    <h1>{{ $city->getName() ?? '' }}</h1>
                    <h2 class="current">{{ __('trenutno') }}</h2>
                </div>
                <p class="datetime">{{ $dateTime }}</p>
            </div>
            <div class="temperature__wrapper">
                <div class="temperature__info">
                    <h3>{{ $city->twelveHoursCurrentRel->phase ?? '' }}</h3>
                </div>
                <div class="temperature__iww">
                    <div class="info__wrapper">
                        <div class="main__info__w">
                            <div class="miw__temp">
                                <div class="img__wrapper">
                                    <img src="{{ asset('files/images/weathericons/' . ( $city->twelveHoursCurrentRel->icon ?? '1' ) . '.png') }}" alt="{{ __('Weather icon') }}">
                                </div>
                                <div class="temp__wrapper">
                                    <p>{{ temperatureHelper::roundUp($city->twelveHoursCurrentRel->temperature ?? '0') }}°C</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="real__feel__mobile">
                        <h3>{{ __('Realan osjećaj') }} {{ temperatureHelper::roundUp($city->twelveHoursCurrentRel->temperature_rf ?? '0') }} °C </h3>
                    </div>

                    <div class="other__info__wrapper">
{{--                        <div class="oiw__info yellow-warning">--}}
{{--                            <p>{{ __('Žuto upozorenje za maglu 00:00 - 11:00h') }}</p>--}}
{{--                        </div>--}}
{{--                        <div class="oiw__info info-warning">--}}
{{--                            <p>{{ __('Srijeda navečer snijeg 20:00 - 23:59') }}</p>--}}
{{--                        </div>--}}

                        <!-- No warnings present -->
                        {{--                    <div class="oiw__info">--}}
                        {{--                        <p>{{ __('Nema aktuelnih upozorenja') }}</p>--}}
                        {{--                    </div>--}}
                    </div>
                </div>
            </div>
            <div class="other__info">
                <div class="other__info__temp" title="{{ $city->twelveHoursCurrentRel->temperature_desc ?? '' }}">
                    <h3>{{ __('Realan osjećaj') }} {{ temperatureHelper::roundUp($city->twelveHoursCurrentRel->temperature_rf ?? '0') }} °C </h3>
                </div>
                <div class="other__info__inner">
                    <div class="oi_w">
                        <h3>{{ __('Vjetar') }}</h3>
                        <p>{{ $city->twelveHoursCurrentRel->wind_speed ?? '' }} km/h</p>
                    </div>
                    <div class="oi_w">
                        <h3>{{ __('Vlažnost') }}</h3>
                        <p>{{ $city->twelveHoursCurrentRel->rel_humidity ?? '' }}%</p>
                    </div>
                    <div class="oi_w">
                        <h3>{{ __('Vidljivost') }}</h3>
                        <p>{{ $city->twelveHoursCurrentRel->visibility ?? '' }}km</p>
                    </div>
                    <div class="oi_w">
                        <h3>{{ __('Tačka orošavanja') }}</h3>
                        <p>{{ $city->twelveHoursCurrentRel->dev_point ?? '' }}°C</p>
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
                            <h3> {{ $tw->getTime() }} </h3>
                            <img src="{{ asset('files/images/weathericons/' . ( $tw->icon ?? '1' ) . '.png') }}" alt="{{ __('Weather icon') }}">
                            <p> @if($tw->icon == "sunrise") {{ __('Izlazak') }} @elseif($tw->icon == "sunset") {{ __('Zalazak') }} @else {{ temperatureHelper::roundUp($tw->temperature ?? '0') }}° @endif</p>
                        </div>
                        @if($tw->effect())
                            <div class="{{ $tw->effect() }}">
{{--                                @if($tw->effect() == "effect snow-effect")--}}
{{--                                    @for($i=0; $i<20; $i++)--}}
{{--                                        <div class="snowflake"> <div class="inner">❅</div> </div>--}}
{{--                                    @endfor--}}
{{--                                @endif--}}
                            </div>
                        @endif
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
                <h3>{{ __('Vjetar') }}</h3>
                <p>{{ $city->twelveHoursCurrentRel->wind_speed ?? '' }} km/h</p>
            </div>
            <div class="mai_w">
                <h3>{{ __('Vlažnost') }}</h3>
                <p>{{ $city->twelveHoursCurrentRel->rel_humidity ?? '' }}%</p>
            </div>
            <div class="mai_w">
                <h3>{{ __('Vidljivost') }}</h3>
                <p>{{ $city->twelveHoursCurrentRel->visibility ?? '' }}km</p>
            </div>
            <div class="mai_w">
                <h3>{{ __('Tačka orošavanja') }}</h3>
                <p>{{ $city->twelveHoursCurrentRel->dev_point ?? '' }}°C</p>
            </div>
        </div>

        @include('public-part.app.forecast.includes.wind-direction')
    </div>
@endsection
