@extends('layouts.app')

@section('title', 'Página home')

@section('content')
<h1>{{ __('messages.welcome') }}</h1>
<h1>@lang('messages.welcome')</h1>

<p>{{ __('messages.example_with_value', ['name' => 'Wandissu']) }}</p>

<p>{{ trans_choice('messages.plural', 0, ['a' => 1]) }}</p>
<p>{{ trans_choice('messages.plural', 1, ['a' => 1]) }}</p>
<p>{{ trans_choice('messages.plural', 2, ['a' => 1]) }}</p>

<p>Using json: {{ __('Welcome to Laravel!') }}</p>
<p>Using json: {{ __('Hello :name', ['name' => 'Wandissu']) }}</p>

<p>This is the content of the main page!</p>
@endsection