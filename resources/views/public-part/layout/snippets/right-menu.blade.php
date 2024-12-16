<div class="right__menu transition-05">
    <div class="menu__body">
        <div class="rm__header">
            <div class="rm__info">
                <img src="{{ asset('files/images/icons/cogs.svg') }}" alt="">
                <h2>{{ __('POSTAVKE') }}</h2>
            </div>
            <div class="rm__exit" title="{{ __('Zatvorite') }}">
                <img src="{{ asset('files/images/icons/x-black.svg') }}" class="transition-02" alt="">
            </div>
        </div>

        <div class="city__info" title="{{ __('Vaša trenutna lokacija') }}">
            <a href="#">
                <p>{{ __('Sarajevo, Bosna i Hercegovina') }}</p>
            </a>
        </div>

        <div class="line"></div>

        <div class="forecast__links">
            <div class="fl__row">
                <a href="#">{{ __('Vrijeme danas') }}</a>
            </div>
            <div class="fl__row">
                <a href="#">{{ __('Vrijeme sutra') }}</a>
            </div>
            <div class="fl__row">
                <a href="#">{{ __('Sarajevo 5 dana') }}</a>
            </div>
        </div>

        <div class="line"></div>

        <div class="forecast__links">
            <div class="fl__row">
                <a href="#">{{ __('AccuWeather') }}</a>
            </div>
            <div class="fl__row">
                <a href="#">{{ __('O nama') }}</a>
            </div>
            <div class="fl__row">
                <a href="#">{{ __('Kontaktirajte nas') }}</a>
            </div>
        </div>
    </div>

    <div class="menu__footer">
        <div class="login__wrapper">
            <img src="{{ asset('files/images/icons/login.svg') }}" class="transition-02" alt="">
            <a href="#"> {{ __('Prijavite se') }} </a>
        </div>
        <div class="icons__wrapper">
            <img src="{{ asset('files/images/icons/globe.svg') }}" class="transition-02" alt="">
            <img src="{{ asset('files/images/icons/ig.svg') }}" class="transition-02" alt="">
            <img src="{{ asset('files/images/icons/fb.svg') }}" class="transition-02" alt="">
        </div>
    </div>
</div>
