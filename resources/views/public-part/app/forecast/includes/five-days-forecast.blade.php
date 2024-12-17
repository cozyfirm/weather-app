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
                        <p>@if($i==0) {{ __('Ponedjeljak') }} @else {{ __('Utorak') }}@endif </p>
                        <p class="comma">,</p>
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
