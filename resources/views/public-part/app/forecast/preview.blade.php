@extends('public-part.layout.layout')

@section('public-content')
    <div class="preview__wrapper">
        <div class="current__wrapper">
            <div class="header">
                <div class="city__">
                    <h2>{{ __('Sarajevo') }}</h2>
                    <h2 class="current">{{ __('trenutno') }}</h2>
                </div>
                <p>Subota, 14. Dec 2024 20:06h</p>
            </div>
            <div class="temperature__wrapper">
                <div class="temperature__info">
                    <h4>{{ __('Oblačno') }}</h4>
                </div>
                <div class="temperature__iww">
                    <div class="info__wrapper">
                        <div class="main__info__w">
                            <div class="miw__temp">
                                <div class="img__wrapper">
                                    <img src="https://www.accuweather.com/images/weathericons/36.svg" alt="{{ __('Weather icon') }}">
                                </div>
                                <div class="temp__wrapper">
                                    <h1>4°C</h1>
                                </div>
                            </div>
                        </div>
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
                <div class="other__info__temp">
                    <h5>{{ __('Realan osjećaj kao 8°C') }}</h5>
                </div>
                <div class="other__info__inner">
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
        </div>

        <!-- Twelve hours forecast -->
        <div class="twelve__hours__wrapper">
            <div class="swiper multi-swiper">
                <div class="swiper-wrapper">
                    @php $i = 0; @endphp
                    @for($i=0; $i<12; $i++)
                        <div class="swiper-slide transition-05">
                            <div class="inside-swiper @if($i == 3) active @endif">
                                <p> {{ $i+12 }}:00 </p>
                                <img src="https://www.accuweather.com/images/weathericons/{{ 36 }}.svg" alt="{{ __('Weather icon') }}">
                                <h5> {{ $i - 3 }}° </h5>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>

        <!-- Only on mobile version, show this data at before five days forecast -->
        <div class="mobile__additional_info">
            <div class="mai_w">
                <p>{{ __('Vjetar') }}</p>
                <h5>15 km/h</h5>
            </div>
            <div class="mai_w">
                <p>{{ __('Vlažnost') }}</p>
                <h5>30%</h5>
            </div>
            <div class="mai_w">
                <p>{{ __('Vidljivost') }}</p>
                <h5>12km</h5>
            </div>
            <div class="mai_w">
                <p>{{ __('Tačka orošavanja') }}</p>
                <h5>-1.3°C</h5>
            </div>
        </div>

        <!-- Five days forecast -->
        @include('public-part.app.forecast.includes.five-days-forecast')
    </div>
@endsection
