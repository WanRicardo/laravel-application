@extends('layouts.app')

@section('title', 'Página contact')
@section('content')
<h1>Contact Page</h1>
<p>Hello this is contact</p>

@can('home.secret')
    <p>
        <a href="{{ route('secret') }}">
            Gto to special contact details!
        </a>
    </p>    
@endcan
@endsection