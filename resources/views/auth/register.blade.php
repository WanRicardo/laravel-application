@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="" value="{{ old('name') }}" required 
                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
            
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="text" name="email" id="" value="{{ old('email') }}" required 
                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">

            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="" required
                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                
            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="password_confimation">Retyped Password</label>
            <input type="password" name="password_confirmation" id="" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
@endsection