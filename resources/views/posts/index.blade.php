@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    <div class="row">
        <div class="col-8">
            {{--  @each('posts.partials.post', $posts, 'post')  --}}
            @forelse ($posts as $key => $post)
                @include('posts.partials.post')
            @empty
            No posts founde!
            @endforelse
    
            {{--  @for ($i = 0; $i < 10; $i++)
                <div>The current value is: {{ $i }}</div>
            @endfor
    
            @php
                $done = false
            @endphp
    
            @while (!$done)
                <div>I'm not done</div>
    
                @php
                    if(random_int(0,1) == 1) $done = true
                @endphp
            @endwhile  --}}
        </div>
        <div class="col-4">
            <div class="container">
                <div class="row">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Most Commented</h5>
                            <h6 class="card-subtitle m-2 text-muted">What people are currently talking about</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row mt-4">
                    <x-card title="Most Active" subtitle="Writers with most posts written" :items="collect($mostActive)->pluck('name')" />
                </div>

                <div class="row mt-4">
                    <x-card title="Most Active Last Month" subtitle="Users with most posts written in the month" :items="collect($mostActiveLastMonth)->pluck('name')" />
                </div>
            </div>
        </div>
    </div>
@endsection