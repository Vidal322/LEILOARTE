@extends('layouts.app')

@section('content')
    <div class="faq-list">
    @foreach ($faqs as $faq)
    <div class="faq-card">
        @include('partials.faqCard', ['faq' => $faq])
    </div>
    @endforeach
    </div>

@endsection