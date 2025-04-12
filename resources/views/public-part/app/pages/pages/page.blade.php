@extends('public-part.layout.layout')

@section('public-content')
    <div class="page__wrapper">
        <div class="page__inner_wrapper">
            {!! nl2br($page->description) !!}
        </div>
    </div>
@endsection
