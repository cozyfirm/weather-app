@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-file"></i> @endsection
@section('c-title') {{ __('Single pages') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> / <a href="{{ route('system.admin.other.single-pages') }}">{{ __('Single pages') }}</a>
@endsection
@section('c-buttons')
    <a href="#">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        @include('admin.layout.snippets.filters.filter-header', ['var' => $pages])
        <table class="table table-bordered" id="filtering">
            <thead>
            <tr>
                <th scope="col" style="text-align:center;">#</th>
                @include('admin.layout.snippets.filters.filters_header')
                <th width="120p" class="akcije text-center">{{__('Akcije')}}</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @foreach($pages as $page)
                <tr>
                    <td class="text-center">{{ $i++}}.</td>
                    <td> {{ $page->title ?? ''}} </td>

                    <td class="text-center">
                        <a href="{{route('system.admin.other.single-pages.edit', ['id' => $page->id] )}}" title="{{ __('Više informacija') }}">
                            <button class="btn btn-dark btn-xs">{{ __('Uredite') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.layout.snippets.filters.pagination', ['var' => $pages])
    </div>
@endsection
