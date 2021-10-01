@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image ? $user->image->url() : '' }}" class="img-thumbnail avatar">
        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>
            
            <x-comment-form :route="route('users.comments.store', ['user' => $user->id])"/>
    
            <x-comment-list :comments="$user->commentsOn"/>
        </div>
    </div>
@endsection