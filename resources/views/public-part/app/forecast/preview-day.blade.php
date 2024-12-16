@extends('public-part.layout.layout')

@section('public-content')
    <div class="preview__wrapper">
        <div class="specific__day__wrapper">
            <div class="sdw__header">
                <h2>Sarajevo, 16. Dec 2024</h2>
                <div class="sdw__h__options">
                    <div class="sdw__h__o_option active">
                        {{ __('Dan') }}
                    </div>
                    <div class="sdw__h__o_option">
                        {{ __('Večer') }}
                    </div>
                </div>
            </div>

            <div class="sdw__body">
                <div class="text__info">
                    <p>Srijeda</p>
                    <h4>Očekuje se malo kiše</h4>
                    <div class="warnings__wrapper">
                        <div class="oiw__info yellow-warning">
                            <p>{{ __('Žuto upozorenje za maglu 00:00 - 11:00h') }}</p>
                        </div>
                        <div class="oiw__info info-warning">
                            <p>{{ __('Srijeda navečer snijeg 20:00 - 23:59') }}</p>
                        </div>
                    </div>
                    <p>Izlazak sunca u 07:54h, zalazak u 16:03h !</p>
                </div>
                <div class="temperature__info">
                    <div class="temp__info__inner">
                        <div class="tii__text">
                            <p>{{ __('Osjeća se kao') }} 11° | 17°C </p>
                            <h2>12° | 17°C</h2>
                        </div>
                        <img src="https://www.accuweather.com/images/weathericons/18.svg" alt="{{ __('Weather icon') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="other__info__wrapper">
            <div class="oiw__inner transition-05">
                <div class="oiw__i__header">
                    <p>{{ __('Vlažnost') }}</p>
                    <img src="{{ asset('files/images/icons/humidity.svg') }}" alt="">
                </div>
                <div class="oiw__i__body">
                    <h3>80%</h3>
                </div>
                <div class="oiw__i__footer">
                    <div class="line__wrapper"> <div class="fill__line width-80"></div> </div>
                    <div class="line__desc">
                        <span>0%</span>
                        <span>100%</span>
                    </div>
                </div>
            </div>
            <div class="oiw__inner transition-05">
                <div class="oiw__i__header">
                    <p>{{ __('UV Index') }}</p>
                    <img src="{{ asset('files/images/icons/sun.svg') }}" alt="">
                </div>
                <div class="oiw__i__body">
                    <h3>3</h3>
                </div>
                <div class="oiw__i__footer">
                    <div class="line__wrapper"> <div class="fill__line width-30"></div> </div>
                    <div class="line__desc">
                        <span>0</span>
                        <span>10</span>
                    </div>
                </div>
            </div>
            <div class="oiw__inner transition-05">
                <div class="oiw__i__header">
                    <p>{{ __('Padavine') }}</p>
                    <img src="{{ asset('files/images/icons/precipitation.svg') }}" alt="">
                </div>
                <div class="oiw__i__body">
                    <h3>93%</h3>
                </div>
                <div class="oiw__i__footer">
                    <div class="line__wrapper"> <div class="fill__line width-93"></div> </div>
                    <div class="line__desc">
                        <span>0%</span>
                        <span>100%</span>
                    </div>
                </div>
            </div>
            <div class="oiw__inner transition-05">
                <div class="oiw__i__header">
                    <p>{{ __('Kiša') }}</p>
                    <img src="{{ asset('files/images/icons/rain.svg') }}" alt="">
                </div>
                <div class="oiw__i__body">
                    <h3>1.5mm</h3>
                </div>
                <div class="oiw__i__footer">
                    <div class="line__wrapper"> <div class="fill__line width-15"></div> </div>
                    <div class="line__desc">
                        <span>0mm</span>
                        <span>10mm</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Five days forecast -->
        @include('public-part.app.forecast.includes.five-days-forecast')
    </div>
@endsection
