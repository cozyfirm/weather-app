@extends('public-part.layout.layout')

@section('public-content')
    <div class="preview__wrapper">
        <div class="current__wrapper">
            <div class="header">
                <h2>{{ __('Sarajevo, Federation of Bosnia and Herzegovina') }}</h2>
                <p>Subota, 14.12.2024 20:06h</p>
            </div>
            <div class="temperature__wrapper">
                <div class="info__wrapper">
                    <div class="main__info__w">
                        <div class="img__wrapper">
                            <img src="https://www.accuweather.com/images/weathericons/36.svg" alt="{{ __('Weather icon') }}">
                        </div>
                        <div class="temp__wrapper">
                            <h1>4°C</h1>
                        </div>
                        <div class="info__inner_wrapper">
                            <div class="ii_i_w">
                                <h6>Oblačno</h6>
                                <p>Osjećao se kao 5°C</p>
                            </div>
                        </div>
                    </div>

                    <div class="text__wrapper">
                        <p>{{ __('Najniža temperatura -3°C, najviša 7°C') }}</p>
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
            <div class="other__info">
{{--                <div class="oi_w">--}}
{{--                    <p>{{ __('Kvalitet zraka') }}</p>--}}
{{--                    <h5>24</h5>--}}
{{--                </div>--}}
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
            </div>
        </div>

        <!-- Five days forecast -->
        <div class="five__days__wrapper">
            <div class="five__days__inner_wrapper">
                <div class="inner__header">
                    <img src="{{ asset('files/images/icons/location.svg') }}" alt="">
                    <h3><b>Sarajevo</b> {{ __('pet dana') }}</h3>
                </div>

                <div class="body__data">
                    @for($i=0; $i<5; $i++)
                        <div class="day__forecast transition-05">
                            <div class="day__title">
                                <p>@if($i==0) {{ __('Ponedjeljak') }} @else {{ __('Utorak') }}@endif, </p>
                                <span>{{ $i + 14 }}. Decembar </span>
                            </div>
                            <div class="day__forecast_info">
                                <div class="warning__info">
                                    <div class="warning__w yellow-warning"> <p>!</p> </div>
                                    <div class="warning__w info-warning"> <p>!</p> </div>
                                </div>

                                <div class="temperature__info">
                                    <p>8°</p>
                                    <span>|</span>
                                    <p>16°</p>
                                </div>

                                <div class="wind__info">
                                    <img src="{{ asset('files/images/icons/wind.svg') }}" alt="">
                                    <div class="wind__text">
                                        <p>ZSZ</p>
                                        <span>{{ $i }} km/h</span>
                                    </div>
                                </div>

                                <img src="https://www.accuweather.com/images/weathericons/{{ $i + 32 }}.svg" alt="{{ __('Weather icon') }}">
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="wind__direction">
                <div class="wind__direction__header">
                    <p>{{ __('Vjetar') }}</p>
                    <img src="{{ asset('files/images/icons/wind.svg') }}" alt="">
                </div>
                <div class="compass__wrapper">
                    <div class="compass__animation_wrapper">
                        <div class="compass__circle">
                            <img src="{{ asset('files/images/icons/compass.png') }}" alt="">
                            <div class="position north">{{ __('S') }}</div>
                            <div class="position east">{{ __('I') }}</div>
                            <div class="position south">{{ __('J') }}</div>
                            <div class="position west">{{ __('Z') }}</div>
                        </div>
                    </div>
                    <div class="compass__info_wrapper">
                        <div class="ciw__inner">
                            <p>Iz pravca ZJZ (36°)</p>
                            <div class="wind__info">
                                <h3>8</h3>
                                <div class="wind__info__text">
                                    <p>km/h</p>
                                    <p>Brzina vjetra</p>
                                </div>
                            </div>
                            <div class="wind__info">
                                <h3>25</h3>
                                <div class="wind__info__text">
                                    <p>km/h</p>
                                    <p>Udari vjetra</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wind__info">
                    <p>
                        {{ __('Umjeren, sa prosječnom brzinom od 8 km/h.') }}
                        {{ __('Očekuju se udari vjetra do 25 km/h!') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
