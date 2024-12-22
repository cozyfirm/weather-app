<div class="mobile__search_wrapper ">
    <div class="msw__search__area">
        <div class="msw_sa_search_w">
            <div class="msw_sw_icon__wrapper">
                <img src="{{ asset('files/images/icons/search-white.svg') }}" alt="">
            </div>
            <div class="msw_sw_input__wrapper">
                <input type="text" name="search" id="mobile-menu-search" class="mobile-menu-search" uri="{{ route('public.forecast.api-routes.search-by-text') }}" placeholder="{{ __('Unesi svoju lokaciju') }}">
            </div>
        </div>
        <div class="msw_sa_cancel_w">
            <p>{{ __('Odustani') }}</p>
        </div>
    </div>

    <div class="msw__search__body">
        <div class="search__row d-none">
            <img src="{{ asset('files/images/icons/search-white.svg') }}" alt="">
            <p id="searched__value"></p>
        </div>

        @if($history->count())
            <div class="previous__search_w">
                <div class="psw__header">
                    <p>{{ __('Posljednje pretraživano') }}</p>
                    <p>{{ HistoryHelper::lastSearch() }}</p>
                </div>
                <div class="psw_row__w">
                    @foreach($history as $sample)
                        <div class="psw__row skip-closing go-to" uri="{{ route('public.forecast.preview', ['cityKey' => $sample->city_key ?? '0']) }}">
                            <div class="psw_r_data skip-closing">
                                <h6 class="skip-closing">{{ $sample->cityRel->name ?? '' }}</h6>
                                <p class="skip-closing">{{ $sample->cityRel->country ?? '' }}</p>
                            </div>
                            <div class="psw_r_info skip-closing">
                                <img class="skip-closing" src="https://www.accuweather.com/images/weathericons/{{ $sample->cityRel->twelveHoursCurrentRel->icon ?? '' }}.svg" alt="{{ __('Weather icon') }}">
                                <h4 class="skip-closing">{{ temperatureHelper::roundUp($sample->cityRel->twelveHoursCurrentRel->temperature ?? '0') }}°C</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
