<div class="five__days__wrapper">
    <div class="five__days__inner_wrapper">
        <div class="inner__header">
            <img src="{{ asset('files/images/icons/location.svg') }}" alt="">
            <h3><b>Sarajevo</b> {{ __('pet dana') }}</h3>
        </div>

        <div class="body__data">
            @foreach($city->fiveDaysRel as $day)
                <div class="day__forecast transition-05" title="{{ $day->dayRel->long_phrase ?? '' }}">
                    <div class="day__title">
                        <p> {{ $day->weekDay() }} </p>
                        <p class="comma">,</p>
                        <span> {{ $day->dateAndMonth() }} </span>
                    </div>
                    <div class="day__forecast_info">
                        <div class="warning__info">
                            <div class="warning__w yellow-warning"> <p>!</p> </div>
                            <div class="warning__w info-warning"> <p>!</p> </div>
                        </div>

                        <div class="temperature__info">
                            <p>{{ $day->min_temp ?? '0' }}°</p>
                            <span>|</span>
                            <p>{{ $day->max_temp ?? '0' }}°</p>
                        </div>

                        <!-- ToDo: Day or night -->

                        <div class="wind__info">
                            <img src="{{ asset('files/images/icons/wind.svg') }}" alt="">
                            <div class="wind__text">
                                <p>{{ $day->dayRel->wind_direction_l ?? '' }}</p>
                                <span> {{ $day->dayRel->wind_speed ?? '' }} km/h</span>
                            </div>
                        </div>

                        <img src="https://www.accuweather.com/images/weathericons/{{ $day->dayRel->icon ?? 0 }}.svg" alt="{{ __('Weather icon') }}">
                    </div>
                </div>
            @endforeach
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
                    <img class="rotate-{{ $city->twelveHoursCurrentRel->wind_direction_deg ?? '0' }}" src="{{ asset('files/images/icons/compass.png') }}" alt="">
                    <div class="position north">{{ __('S') }}</div>
                    <div class="position east">{{ __('I') }}</div>
                    <div class="position south">{{ __('J') }}</div>
                    <div class="position west">{{ __('Z') }}</div>
                </div>
            </div>
            <div class="compass__info_wrapper">
                <div class="ciw__inner">
                    <p>Iz pravca {{ $city->twelveHoursCurrentRel->wind_direction_l ?? 'I' }} ({{ $city->twelveHoursCurrentRel->wind_direction_deg ?? 'I' }}°)</p>
                    <div class="wind__info">
                        <h3>{{ $city->twelveHoursCurrentRel->wind_speed ?? 'I' }}</h3>
                        <div class="wind__info__text">
                            <p>km/h</p>
                            <p>{{ __('Brzina vjetra') }}</p>
                        </div>
                    </div>
                    <div class="wind__info">
                        <h3>{{ $city->twelveHoursCurrentRel->wind_gust_speed ?? 'I' }}</h3>
                        <div class="wind__info__text">
                            <p>km/h</p>
                            <p>{{ __('Udari vjetra') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wind__info">
            <p>
                ToDo::
                {{ __('Umjeren, sa prosječnom brzinom od 8 km/h.') }}
                {{ __('Očekuju se udari vjetra do 25 km/h!') }}
            </p>
        </div>
    </div>
</div>
