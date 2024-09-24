@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-question"></i> @endsection
@section('c-title') {{ __('FAQ') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> / <a href="{{ route('system.admin.other.faq') }}">{{ __('FAQ') }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.other.faq') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($edit))
        <a href="{{ route('system.admin.other.faq.delete', ['id' => $faq->id ]) }}">
            <button class="pm-btn btn pm-btn-trash">
                <i class="fas fa-trash"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        @if(session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session()->get('success') }}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger mt-3">
                {{ session()->get('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <form action="@if(isset($edit)) {{ route('system.admin.other.faq.update') }} @else {{ route('system.admin.other.faq.save') }} @endif" method="POST" id="js-form">
                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($faq->id) }}
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Naslov'))->for('title')->class('bold') }}
                                {{ html()->text('title', $faq->title ?? '' )->class('form-control form-control-sm')->required()->value((isset($faq) ? $faq->title : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Sekcija'))->for('country')->class('bold') }}
                                {{ html()->select('what', $other, isset($faq) ? $faq->what : '')->class('form-control form-control-sm mt-1')->required()->disabled(isset($preview)) }}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Detaljan opis'))->for('description')->class('bold') }}
                                {{ html()->textarea('description')->class('form-control form-control-sm mt-2 textarea-240 summernote')->value(isset($faq) ? $faq->description : '')->isReadonly(isset($preview)) }}
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
