@extends('layouts.app')

@section('content')
    <div class="faq-list">
        @foreach ($faqs as $faq)
                @include('partials.faqCard', ['faq' => $faq])
        @endforeach
    </div>
@endsection
