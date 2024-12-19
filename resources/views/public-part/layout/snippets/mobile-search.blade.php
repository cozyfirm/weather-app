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

        <div class="previous__search_w">
            <div class="psw__header">
                <p>{{ __('Posljednje pretraživano') }}</p>
                <p>16. Dec 20:03</p>
            </div>
            <div class="psw_row__w">
                @for($i=0; $i<6; $i++)
                    <div class="psw__row skip-closing go-to" uri="{{ route('public.forecast.preview', ['citiKey' => 12]) }}">
                        <div class="psw_r_data skip-closing">
                            <h6 class="skip-closing">Sarajevo</h6>
                            <p class="skip-closing">Federacija Bosne i Hercegovine</p>
                        </div>
                        <div class="psw_r_info skip-closing">
                            <img class="skip-closing" src="https://www.accuweather.com/images/weathericons/4.svg" alt="{{ __('Weather icon') }}">
                            <h4 class="skip-closing">{{ $i + 3 }}°C</h4>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
