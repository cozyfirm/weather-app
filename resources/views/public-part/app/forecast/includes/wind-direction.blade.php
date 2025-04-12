<div class="wind__direction">
    <div class="wind__direction__header">
        <p>{{ __('Vjetar') }}</p>
        <img src="{{ asset('files/images/icons/wind.svg') }}" alt="">
    </div>
    <div class="compass__wrapper">
        <div class="compass__animation_wrapper">
            <div class="compass__circle">
                <img class="rotate-{{ isset($previewDay) ? $info->wind_direction_deg ?? '0' : $city->twelveHoursCurrentRel->wind_direction_deg ?? '0' }}" src="{{ asset('files/images/icons/compass.png') }}" alt="">
                <div class="position north">{{ __('S') }}</div>
                <div class="position east">{{ __('I') }}</div>
                <div class="position south">{{ __('J') }}</div>
                <div class="position west">{{ __('Z') }}</div>
            </div>
        </div>
        <div class="compass__info_wrapper">
            <div class="ciw__inner">
                <p>
                    Iz pravca
                    @if(isset($previewDay))
                        {{ $info->wind_direction_l ?? 'I' }} ({{ $info->wind_direction_deg ?? 'I' }}°)
                    @else
                        {{ $city->twelveHoursCurrentRel->wind_direction_l ?? 'I' }} ({{ $city->twelveHoursCurrentRel->wind_direction_deg ?? 'I' }}°)
                    @endif
                </p>
                <div class="wind__info">
                    <h3>
                        @if(isset($previewDay))
                            {{ $info->wind_speed ?? '0km/h' }}
                        @else
                            {{ $city->twelveHoursCurrentRel->wind_speed ?? '0km/h' }}
                        @endif
                    </h3>
                    <div class="wind__info__text">
                        <p>km/h</p>
                        <p>{{ __('Brzina vjetra') }}</p>
                    </div>
                </div>
                <div class="wind__info">
                    <h3>
                        @if(isset($previewDay))
                            {{ $info->wind_gust_speed ?? 'I' }}
                        @else
                            {{ $city->twelveHoursCurrentRel->wind_gust_speed ?? 'I' }}
                        @endif
                    </h3>
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
            @if(isset($previewDay))
                {{ WindHelper::windSpeed($info->wind_speed ?? '0') }}
                {{ WindHelper::windGustSpeed($info->wind_gust_speed ?? '0') }}
            @else
                {{ WindHelper::windSpeed($city->twelveHoursCurrentRel->wind_speed ?? '0') }}
                {{ WindHelper::windGustSpeed($city->twelveHoursCurrentRel->wind_gust_speed ?? '0') }}
            @endif
        </p>
    </div>
</div>
