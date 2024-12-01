@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-building"></i> @endsection
@section('c-title') {{ __('Unos') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.base.cities') }}">{{ __('Pregled baznih gradova') }}</a> /
    <a href="#">{{ __('Unos') }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.base.cities') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('system.admin.base.cities.save') }}" method="POST" id="js-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input__search_wrapper">
                                <label for="club_name"> <b>{{ __('Vaš klub') }}</b> </label>
                                <input type="text" name="searched_value" class="searched-value c-select-2" s-input="city" s-val="" id="city-name" route="{{ route('system.admin.base.cities.fetch') }}" aria-describedby="cityHel" >
                                <small id="cityHel" class="form-text text-muted" default="{{ __('Odaberite željeni grad') }}"> {{ __('Odaberite željeni grad') }} </small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-dark btn-sm"> {{ __('SAČUVAJTE') }} </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
