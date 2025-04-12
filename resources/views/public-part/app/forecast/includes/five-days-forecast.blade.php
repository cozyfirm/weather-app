<div class="five__days__wrapper" id="five__days__wrapper">
    <div class="five__days__inner_wrapper">
        <div class="inner__header">
            <img src="{{ asset('files/images/icons/location.svg') }}" alt="">
            <h3><b>{{ $city->name ?? '' }}</b> {{ __('pet dana') }}</h3>
        </div>

        <div class="body__data">
            @foreach($city->fiveDaysRel as $day)
                <a href="{{ route('public.forecast.preview-day', ['cityKey' => $city->key, 'date' => $day->date, 'type' => 'day']) }}">
                    <div class="day__forecast transition-05" title="{{ $day->dayRel->long_phrase ?? '' }}">
                        <div class="day__title">
                            <p> {{ $day->weekDay() }} </p>
                            <p class="comma">,</p>
                            <span> {{ $day->dateAndMonth() }} </span>
                        </div>
                        <div class="day__forecast_info">
                            <img src="{{ asset('files/images/weathericons/' . ( $day->dayRel->icon ?? '1' ) . '.png') }}" alt="{{ __('Weather icon') }}">

                            <div class="temperature__info">
                                <p>{{ temperatureHelper::roundUp($day->min_temp ?? '0') }}°</p>
                                <span>|</span>
                                <p>{{ temperatureHelper::roundUp($day->max_temp ?? '0') }}°</p>
                            </div>

{{--                            <div class="warning__info">--}}
{{--                                <div class="warning__w yellow-warning"> <p>!</p> </div>--}}
{{--                                <div class="warning__w info-warning"> <p>!</p> </div>--}}
{{--                            </div>--}}

                            <!-- ToDo: Day or night -->

                            <div class="wind__info">
                                <img src="{{ asset('files/images/icons/wind.svg') }}" alt="">
                                <div class="wind__text">
                                    <p>{{ $day->dayRel->wind_direction_l ?? '' }}</p>
                                    <span> {{ $day->dayRel->wind_speed ?? '' }} km/h</span>
                                </div>
                            </div>


                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
