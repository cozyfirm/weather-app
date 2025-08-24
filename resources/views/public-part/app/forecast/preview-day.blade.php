@extends('public-part.layout.layout')

@section('title'){{ __("Vremenska prognoza za ") . $city->getName() }}@endsection
@section('meta_uri'){{ route('public.forecast.preview-day', ['cityKey' => $city->key, 'date' => $date, 'type' => $type]) }}@endsection
@section('meta_title'){{ __("Vremenska prognoza za ") . $city->getName() }}@endsection
@section('meta_desc'){{ __("Vremenska prognoza za ") . $city->getName()  . __(". Dnevna temperatura od ") . (temperatureHelper::roundUp($fiveDays->min_temp ?? '0')) . "°C do " . (temperatureHelper::roundUp($fiveDays->max_temp ?? '0')) . "°C. " . ($info->long_phrase ?? '')}}@endsection
@section('meta_img'){{ asset('files/images/weathericons/' . ( $info->icon ?? '1' ) . '.png') }}@endsection
@section('meta_canonical'){{ route('public.forecast.preview-by-slug', ['slug' => $city->slug ?? 0]) }}@endsection

@section('public-content')
    <div class="preview__wrapper">
        <div class="specific__day__wrapper">
            <div class="sdw__header">
                <div class="sdw__header__w">
                    <h2>{{ $city->getName() ?? '' }}</h2>
                    @if($dayTitle != 'danas' and $dayTitle != 'sutra' and $dayTitle != 'večeras' and $dayTitle != 'sutra večer')
                        <h2 class="comma">,</h2>
                    @endif
                    <h2 class="date">{{ $dayTitle }}</h2>
                </div>
                <div class="sdw__h__options">
                    <a href="{{ route('public.forecast.daily-by-slug', ['slug' => $city->slug, 'date' => $date, 'type' => 'day']) }}" title="{{ __('Dnevna prognoza') }}">
                        <div class="sdw__h__o_option @if($type == 'day') active @else animated pulse infinite @endif">
                            {{ __('DAN') }}
                        </div>
                    </a>
                    <a href="{{ route('public.forecast.daily-by-slug', ['slug' => $city->slug, 'date' => $date, 'type' => 'night']) }}" title="{{ __('Večernja prognoza') }}">
                        <div class="sdw__h__o_option @if($type == 'night') active @else animated pulse infinite @endif">
                            {{ __('VEČER') }}
                        </div>
                    </a>
                </div>
            </div>

            <div class="sdw__body">
                <div class="text__info">
                    <p>{{ $dayName }}</p>
                    <h4> {{ $info->long_phrase ?? '' }} </h4>
                    <div class="warnings__wrapper">
{{--                        <div class="oiw__info yellow-warning">--}}
{{--                            <p>{{ __('Žuto upozorenje za maglu 00:00 - 11:00h') }}</p>--}}
{{--                        </div>--}}
{{--                        <div class="oiw__info info-warning">--}}
{{--                            <p>{{ __('Srijeda navečer snijeg 20:00 - 23:59') }}</p>--}}
{{--                        </div>--}}
                    </div>
                    <p>Izlazak sunca u {{ $fiveDays->getSunrise() }}h, zalazak u {{ $fiveDays->getSunset() }}h !</p>
                </div>
                <div class="temperature__info">
                    <div class="temp__info__inner">
                        <div class="tii__text">
                            <p>{{ __('Realan osjećaj') }} {{ temperatureHelper::roundUp($fiveDays->min_temp_rf ?? '0') }}° | {{ temperatureHelper::roundUp($fiveDays->max_temp_rf ?? '0') }}°C </p>
                            <h2>{{ temperatureHelper::roundUp($fiveDays->min_temp ?? '0') }}° | {{ temperatureHelper::roundUp($fiveDays->max_temp ?? '0') }}°C</h2>
                        </div>
                        <img src="{{ asset('files/images/weathericons/' . ( $info->icon ?? '1' ) . '.png') }}" alt="{{ __('Weather icon') }}">
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
                    <h3>{{ $info->rel_humidity_avg ?? '0' }}%</h3>
                </div>
                <div class="oiw__i__footer">
                    <div class="line__wrapper"> <div class="fill__line width-{{ $info->rel_humidity_avg ?? '0' }}"></div> </div>
                    <div class="line__desc">
                        <span>0%</span>
                        <span>100%</span>
                    </div>
                </div>
            </div>
            <div class="oiw__inner transition-05" title="{{ $fiveDays->uv_index_desc ?? '' }}">
                <div class="oiw__i__header">
                    <p>{{ __('UV Index') }}</p>
                    <img src="{{ asset('files/images/icons/sun.svg') }}" alt="">
                </div>
                <div class="oiw__i__body">
                    <h3> @if($type == 'night') 0 @else {{ $fiveDays->uv_index ?? '' }} @endif </h3>
                </div>
                <div class="oiw__i__footer">
                    <div class="line__wrapper"> <div class="@if($type == 'night') fill__line width-0 @else fill__line width-{{ ($fiveDays->uv_index ?? '0') * 10 }} @endif"></div> </div>
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
                    <h3>{{ $info->precipitation_probability ?? '0' }}%</h3>
                </div>
                <div class="oiw__i__footer">
                    <div class="line__wrapper"> <div class="fill__line width-{{ $info->precipitation_probability ?? '0' }}"></div> </div>
                    <div class="line__desc">
                        <span>0%</span>
                        <span>100%</span>
                    </div>
                </div>
            </div>
            @if((($info->snow_probability ?? '0') > ($info->rain_probability ?? '0')) and ($info->total_snow ?? '0') > 0)
                <div class="oiw__inner transition-05">
                    <div class="oiw__i__header">
                        <p>{{ __('Snijeg') }}</p>
                        <img src="{{ asset('files/images/icons/rain.svg') }}" alt="">
                    </div>
                    <div class="oiw__i__body">
                        <h3>{{ $info->total_snow ?? 0 }}cm</h3>
                    </div>
                    <div class="oiw__i__footer">
                        <div class="line__wrapper"> <div class="fill__line width-{{ (int)(($info->total_snow ?? 0) * 10) }}"></div> </div>
                        <div class="line__desc">
                            <span>0cm</span>
                            <span>100cm</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="oiw__inner transition-05">
                    <div class="oiw__i__header">
                        <p>{{ __('Kiša') }}</p>
                        <img src="{{ asset('files/images/icons/rain.svg') }}" alt="">
                    </div>
                    <div class="oiw__i__body">
                        <h3>{{ $info->total_rain ?? 0 }}mm</h3>
                    </div>
                    <div class="oiw__i__footer">
                        <div class="line__wrapper"> <div class="fill__line width-{{ (int)(($info->total_rain ?? 0) * 2) }}"></div> </div>
                        <div class="line__desc">
                            <span>0mm</span>
                            <span>50mm</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Five days forecast -->
        @include('public-part.app.forecast.includes.five-days-forecast')

        @include('public-part.app.forecast.includes.wind-direction')
    </div>
@endsection
