@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-building"></i> @endsection
@section('c-title') @isset($create) {{ __('Unos') }} @else @endif @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.users') }}">{{ __('Pregled svih korisnika') }}</a> /
    @if(!isset($user))
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="{{ route('system.admin.users.preview', ['username' => $user->username ]) }}">{{ $user->name }}</a>
    @endif
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.base.cities') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="{{ route('system.admin.users.edit', ['username' => $user->username ]) }}">
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
                <form action="{{ route('system.admin.base.cities.save') }}" method="POST" id="js-form">
                    <div class="input__search_wrapper">
                        {{ html()->hidden('selected_value')->class('form-control') }}
                        {{ html()->text('searched_value', '' )->class('searched-value')->required()->value('')->isReadonly(isset($preview)) }}

                        <div class="available__options">
                            @for($i=0; $i<10; $i++)
                                <div class="option" value="1">
                                    Testni podatak
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Ime i prezime'))->for('name')->class('bold') }}
                                {{ html()->text('name', $user->name ?? '' )->class('form-control form-control-sm')->required()->value((isset($user) ? $user->name : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Email'))->for('email')->class('bold') }}
                                {{ html()->text('email')->class('form-control form-control-sm')->required()->maxlength(150)->value((isset($user) ? $user->email : ''))->isReadonly(isset($preview)) }}
                                <small id="emailHelp" class="form-text text-muted">{{ __('Unesite email') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Uloga'))->for('role')->class('bold') }}
                                {{ html()->select('role', ['user' => 'User', 'admin' => 'Admin' ], isset($user) ? $user->role : '')->class('form-control form-control-sm')->required()->disabled(isset($preview)) }}
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
                            </div>

                            <form action="{{ route('system.admin.users.update-profile-image') }}" method="POST" id="update-profile-image" enctype="multipart/form-data">
                                @csrf
                                {{ html()->hidden('id')->class('form-control')->value($user->id) }}
                                <div class="card p-0 m-0 mt-3" title="{{ __('Nova fotografija za program') }}">
                                    <div class="card-body d-flex justify-content-between">
                                        <label for="photo_uri" >
                                            <p class="m-0">{{ __('Ažurirajte fotografiju') }}</p>
                                        </label>
                                        <i class="fas fa-image mt-1"></i>
                                    </div>
                                    <input name="photo_uri" class="form-control form-control-lg d-none" id="photo_uri" type="file">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
