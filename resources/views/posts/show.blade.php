@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row">
        <div class="col-8">
            @if ($post->image)
                <div style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align: center; background-attachment: fixed">
                    <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
            @else
                <h1>
            @endif
            {{--  @if($post['is_new'])
            <div>A new blog post using if</div>
            @elseif(!$post['is_new'])
            <div>Blog post is old!</div>
            @endif
            @unless($post['is_new'])
            <div>It is an old post using unless</div>    
            @endunless  --}}
                {{ $post->title }}
                <x-badge type='' message='Brand new Post!' show='{{ now()->diffInMinutes($post->created_at) < 20 }}' />
            @if ($post->image)
                    </h1>
                </div>
            @else
                </h1>
            @endif

            <p>{{ $post->content }}</p>

            {{--  <img src="http://laravel.test/storage/{{ $post->image->path }}" alt="">  --}}
            {{--  <img src="{{ asset($post->image->path) }}" alt="">  --}}
            {{--  <img src="{{ $post->image->url() }}" alt="">  --}}

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