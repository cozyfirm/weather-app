<div class="right__menu transition-05">
    <div class="menu__body">
        <div class="rm__header">
            <div class="rm__info">
                <img src="{{ asset('files/images/icons/cogs.svg') }}" alt="{{ __('Ikona podešavanja') }}">
                <h2>{{ __('POSTAVKE') }}</h2>
            </div>
            <div class="rm__exit" title="{{ __('Zatvorite') }}">
                <img src="{{ asset('files/images/icons/x-black.svg') }}" class="transition-02" alt="{{ __('Zatvorite') }}">
            </div>
        </div>

        @if(isset(temperatureHelper::lastSearchedCity()->cityRel))
            <div class="city__info" title="{{ __('Vaša trenutna lokacija') }}">
                <p> {{ temperatureHelper::lastSearchedCity()->cityRel->name ?? '' }}, {{ temperatureHelper::lastSearchedCity()->cityRel->country ?? '' }} </p>
            </div>

            <div class="line"></div>

            <div class="forecast__links">
                <div class="fl__row">
                    <a href="{{ route('public.forecast.preview', ['cityKey' => temperatureHelper::lastSearchedCity()->cityRel->key ?? 0]) }}">
                        {{ __('Vrijeme danas') }}
                    </a>
                </div>
                <div class="fl__row">
                    <a href="{{ route('public.forecast.preview-day', ['cityKey' => temperatureHelper::lastSearchedCity()->cityRel->key ?? 0, 'date' => date("Y-m-d", strtotime('tomorrow')), 'type' => 'day']) }}">
                        {{ __('Vrijeme sutra') }}
                    </a>
                </div>
                <div class="fl__row">
                    @if(Route::is('public.forecast.preview') or Route::is('public.forecast.preview-day'))
                        <a href="#five__days__wrapper">
                            {{ temperatureHelper::lastSearchedCity()->cityRel->name ?? '' }} {{ __('5 dana') }}
                        </a>
                    @else
                        <a href="{{ route('public.forecast.preview', ['cityKey' => temperatureHelper::lastSearchedCity()->cityRel->key ?? 0]) }}#five__days__wrapper">
                            {{ temperatureHelper::lastSearchedCity()->cityRel->name ?? '' }} {{ __('5 dana') }}
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <div class="line"></div>

        <div class="forecast__links">
            <div class="fl__row">
                <a href="https://accuweather.com" target="_blank" rel="nofollow noopener">{{ __('AccuWeather') }}</a>
            </div>
            <div class="fl__row">
                <a href="{{ route('public.pages.about-us') }}">{{ __('O nama') }}</a>
            </div>
            <div class="fl__row">
                <a href="{{ route('public.contact-us') }}">{{ __('Kontaktirajte nas') }}</a>
            </div>
        </div>
    </div>

    <div class="menu__footer">
        <div class="login__wrapper">
            <img src="{{ asset('files/images/icons/login.svg') }}" class="transition-02" alt="{{ __('Ikona za prijavu') }}">
            <a href="{{ route('auth') }}"> {{ __('Prijavite se') }} </a>
        </div>
        <div class="icons__wrapper">
            <img src="{{ asset('files/images/icons/globe.svg') }}" class="transition-02" alt="{{ __('Website') }}">
            <img src="{{ asset('files/images/icons/ig.svg') }}" class="transition-02" alt="{{ __('Instagram') }}">
            <img src="{{ asset('files/images/icons/fb.svg') }}" class="transition-02" alt="{{ __('Facebook') }}">
        </div>
    </div>
</div>
