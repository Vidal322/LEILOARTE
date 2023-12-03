<article>
    <div class="info-container">
        <h3>{{ $faq->question }}</h3>
        <p> {{ $faq->answer}} </p>
        {{-- if admin--}}
        @if (Auth::check() && Auth::user()->type == 'admin')
            <a class="button" id="editFaqButton" href="{{ route('editFAQForm', ['id' => $faq->id]) }}"> Edit </a>
            <form method="POST" class="button" action="{{ route('deleteFAQ', ['id' => $faq->id]) }}">
                @csrf
                @method('POST')
                <button type="submit">Delete</button>
            </form>
        @endif
    </div>
</article>