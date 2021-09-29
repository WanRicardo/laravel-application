@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row">
        <div class="col-8">
            {{--  @if($post['is_new'])
            <div>A new blog post using if</div>
            @elseif(!$post['is_new'])
            <div>Blog post is old!</div>
            @endif
            @unless($post['is_new'])
            <div>It is an old post using unless</div>    
            @endunless  --}}
            <h1>
                {{ $post->title }}
                <x-badge type='' message='Brand new Post!' show='{{ now()->diffInMinutes($post->created_at) < 20 }}' />
            </h1>

            <p>{{ $post->content }}</p>
            <x-updated action="" :date="$post->created_at" name="{{ $post->user->name }}" />
            <x-updated action="Updated" :date="$post->updated_at" name="" />

            <x-tags :tags="$post->tags" />

            <p>Currently read by {{ $counter }} people</p>

            <h4>Comments</h4>

            @include('comments.form')

            @forelse ($post->comments as $comment)
                <p>
                    {{ $comment->content }},
                </p>
                <x-updated action="" :date="$comment->created_at" name="{{ $comment->user->name }}" />
            @empty
                <p>No comments yet!</p>
            @endforelse

            {{--  @isset($post['has_comments'])
                <div>The post has some comments... using isset directive</div>
            @endisset  --}}
        </div>
        <div class="col-4">
            @include('posts.partials.activity')
        </div>
    </div>
@endsection