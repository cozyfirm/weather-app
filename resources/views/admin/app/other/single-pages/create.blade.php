@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-file"></i> @endsection
@section('c-title') {{ __('Single pages') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> / <a href="{{ route('system.admin.other.single-pages') }}">{{ __('Single pages') }}</a> /
    <a href="#">{{ $page->title }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.other.single-pages') }}">
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
                <form action="{{ route('system.admin.other.single-pages.update') }}" method="POST" id="js-form">

                    {{ html()->hidden('id')->class('form-control')->value($page->id) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Naslov'))->for('title')->class('bold') }}
                                {{ html()->text('title', $page->title ?? '' )->class('form-control form-control-sm')->required()->value((isset($page) ? $page->title : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Detaljan opis'))->for('description')->class('bold') }}
                                {{ html()->textarea('description')->class('form-control form-control-sm mt-2 textarea-240 summernote')->value(isset($page) ? $page->description : '')->isReadonly(isset($preview)) }}
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
