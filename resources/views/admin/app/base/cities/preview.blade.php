@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-building"></i> @endsection
@section('c-title') {{ $city->name ?? '' }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.base.cities') }}">{{ __('Pregled baznih gradova') }}</a> /
    <a href="{{ route('system.admin.base.cities.preview', ['id' => $city->id ]) }}">{{ $city->name ?? '' }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.base.cities') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="{{ route('system.admin.base.cities.delete', ['id' => $city->id ]) }}">
            <button class="pm-btn btn pm-btn-edit">
                <i class="fas fa-trash"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        <div class="row">
            <div class="@if(isset($preview)) col-md-9 @else col-md-12 @endif">
                <form action="{{ route('system.admin.base.cities.update') }}" method="POST" id="js-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Naziv grada'))->for('name')->class('bold') }}
                                {{ html()->text('name')->class('form-control form-control-sm')->required()->value((isset($city) ? $city->name : ''))->isReadonly(isset($preview)) }}
                                <small id="emailHelp" class="form-text text-muted">{{ __('Puni naziv grada') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Regija'))->for('region')->class('bold') }}
                                {{ html()->text('region')->class('form-control form-control-sm')->required()->value((isset($city) ? $city->region : ''))->isReadonly(isset($preview)) }}
                                <small id="regionHelp" class="form-text text-muted">{{ __('Regija u kojoj se grad nalazi') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Država'))->for('country')->class('bold') }}
                                {{ html()->text('country')->class('form-control form-control-sm')->required()->value((isset($city) ? $city->country : ''))->isReadonly(isset($preview)) }}
                                <small id="countryHelp" class="form-text text-muted">{{ __('Država u kojoj se grad nalazi') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Oblast'))->for('area')->class('bold') }}
                                {{ html()->text('area')->class('form-control form-control-sm')->required()->value((isset($city) ? $city->area : ''))->isReadonly(isset($preview)) }}
                                <small id="areaHelp" class="form-text text-muted">{{ __('Oblast u kojoj se grad nalazi') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Geografska širina'))->for('latitude')->class('bold') }}
                                {{ html()->text('latitude')->class('form-control form-control-sm')->required()->value((isset($city) ? $city->latitude : ''))->isReadonly(isset($preview)) }}
                                <small id="latitudeHelp" class="form-text text-muted">{{ __('Geografska širina grada') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Geografska dužina'))->for('longitude')->class('bold') }}
                                {{ html()->text('longitude')->class('form-control form-control-sm')->required()->value((isset($city) ? $city->longitude : ''))->isReadonly(isset($preview)) }}
                                <small id="longitudeHelp" class="form-text text-muted">{{ __('Geografska dužina grada') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Nadmorska visina'))->for('elevation')->class('bold') }}
                                {{ html()->text('elevation')->class('form-control form-control-sm')->required()->value((isset($city) ? $city->elevation : ''))->isReadonly(isset($preview)) }}
                                <small id="latitudeHelp" class="form-text text-muted">{{ __('Nadmorska visina na kojoj se grad nalazi (u metrima)') }}</small>
                            </div>
                        </div>
                    </div>

                    @if(!isset($preview))
                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-dark btn-sm"> {{ __('SAČUVAJTE') }} </button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>

            @if(isset($preview))
                <div class="col-md-3 border-left">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card p-0 m-0" title="#">
                                <div class="card-body d-flex justify-content-between">
                                    <h5 class="p-0 m-0"> {{ __('Ostale informacije') }} </h5>
                                    <i class="fas fa-info mt-1 mr-1"></i>
                                </div>
                                <hr class="m-0">

                                <div class="card-body d-flex justify-content-between" title="{{ __('Šifra grada iz API-a') }}">
                                    <h6 class="p-0 m-0"> {{ __('Šifra grada') }} </h6>
                                    <p class="p-0 m-0"><b>{{ $city->key ?? '' }}</b></p>
                                </div>
                            </div>

                            <div class="card p-0 m-0 mt-3" title="#">
                                <div class="card-body d-flex justify-content-between">
                                    <h5 class="p-0 m-0"> {{ __('Vremenski uslovi') }} </h5>
                                    <i class="fas fa-temperature"></i>
                                </div>

                                <div class="card-body d-flex justify-content-between pt-0 pb-0" title="{{ __('Šifra grada iz API-a') }}">
                                    <p class="p-0 m-0"> {{ __('Temperatura') }} </p>
                                    <p class="p-0 m-0"> 10 °C </p>
                                </div>
                                <div class="card-body d-flex justify-content-between pt-0 pb-3" title="{{ __('Šifra grada iz API-a') }}">
                                    <p class="p-0 m-0"> {{ __('Vlažnost') }} </p>
                                    <p class="p-0 m-0"> 47% </p>
                                </div>
                            </div>

{{--                            <form action="{{ route('system.admin.users.update-profile-image') }}" method="POST" id="update-profile-image" enctype="multipart/form-data">--}}
{{--                                @csrf--}}
{{--                                {{ html()->hidden('id')->class('form-control')->value($user->id) }}--}}
{{--                                <div class="card p-0 m-0 mt-3" title="{{ __('Nova fotografija za program') }}">--}}
{{--                                    <div class="card-body d-flex justify-content-between">--}}
{{--                                        <label for="photo_uri" >--}}
{{--                                            <p class="m-0">{{ __('Ažurirajte fotografiju') }}</p>--}}
{{--                                        </label>--}}
{{--                                        <i class="fas fa-image mt-1"></i>--}}
{{--                                    </div>--}}
{{--                                    <input name="photo_uri" class="form-control form-control-lg d-none" id="photo_uri" type="file">--}}
{{--                                </div>--}}
{{--                            </form>--}}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
