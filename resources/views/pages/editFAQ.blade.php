@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('editFAQ', ['id'=> $id]) }}">
    {{ csrf_field() }}

    <label for="question">Question</label>
    <input id="question" type="text" name="question" value="{{ old('question') }}" required autofocus>
    @if ($errors->has('question'))
        <span class="error">
          {{ $errors->first('question') }}
        </span>
    @endif

    <label for="answer" >Answer</label>
    <input id="answer" type="text" name="answer" required>
    @if ($errors->has('answer'))
        <span class="error">
            {{ $errors->first('answer') }}
        </span>
    @endif

    <button type="submit">
        Save
    </button class="button button-outline">
    <a class="button button-outline" href="{{ route('faqs') }}">Cancel</a>
</form>

@endsection