@extends('public-part.layout.layout')

@section('title'){{ $title }} | Vrijeme24.ba @endsection

@section('public-content')
    <div class="page__wrapper">
        <div class="page__inner_wrapper">
            {!! nl2br($page->description) !!}
        </div>
    </div>
@endsection
