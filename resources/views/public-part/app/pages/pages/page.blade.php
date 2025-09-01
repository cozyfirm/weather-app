@extends('public-part.layout.layout')

@section('title'){{ $title }} | Vrijeme24.ba @endsection
@if(isset($privacy))
    @section('meta_canonical'){{ route('public.pages.privacy-policy') }}@endsection
@elseif(isset($terms))
    @section('meta_canonical'){{ route('public.pages.terms-and-conditions') }}@endsection
@elseif(isset($cookies))
    @section('meta_canonical'){{ route('public.pages.cookies') }}@endsection
@elseif(isset($about))
    @section('meta_canonical'){{ route('public.pages.about-us') }}@endsection
@endif

@section('public-content')
    <div class="page__wrapper">
        <div class="page__inner_wrapper">
            {!! nl2br($page->description) !!}
        </div>
    </div>
@endsection
