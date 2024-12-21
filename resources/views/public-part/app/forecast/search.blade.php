@extends('public-part.layout.layout')

@section('public-content')
    <div class="search__wrapper">
        <div class="search__list">
            @foreach($cities as $city)
                <a href="{{ route('public.forecast.preview', ['citiKey' => $city->Key ?? 0]) }}">
                    <div class="search__row">
                        <h5>{{ $city->LocalizedName ?? '' }}</h5>
                        <p> @if(!empty($city->AdministrativeArea->LocalizedName)) {{ $city->AdministrativeArea->LocalizedName ?? '' }}, @endif {{ $city->Country->LocalizedName ?? '' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
{{--        <div class="border__line"></div>--}}
        <div class="side__info">
            @if($history->count())
                <div class="side__info__inner">
                    <div class="si__header">
                        <h4>{{ __('ZADNJE PRETRAŽIVANO') }}</h4>
                    </div>
                    <div class="si__body">
                        @foreach($history as $city)
                            <a href="{{ route('public.forecast.preview', ['citiKey' => $city->cityRel->key ?? 0]) }}">
                                <div class="si__b__row">
                                    <p>{{ $city->cityRel->name ?? '' }}</p>
                                    <div class="weather__icon">
                                        <p>{{ $city->cityRel->twelveHoursCurrentRel->temperature ?? '' }}°C</p>
                                        <img src="https://www.accuweather.com/images/weathericons/{{ $city->cityRel->twelveHoursCurrentRel->icon ?? '' }}.svg" alt="{{ __('Weather icon') }}">
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="side__info__inner">
                <div class="si__header">
                    <h4>{{ __('POPULARNO') }}</h4>
                </div>
                <div class="si__body">
                    @foreach($popular as $city)
                        <a href="{{ route('public.forecast.preview', ['citiKey' => $city->key ?? 0]) }}">
                            <div class="si__b__row">
                                <p>{{ $city->name ?? '' }}</p>
                                <div class="weather__icon">
                                    <p>{{ $city->twelveHoursCurrentRel->temperature ?? '' }}°C</p>
                                    <img src="https://www.accuweather.com/images/weathericons/{{ $city->twelveHoursCurrentRel->icon ?? '' }}.svg" alt="{{ __('Weather icon') }}">
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
