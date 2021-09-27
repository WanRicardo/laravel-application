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
                <div class="row" style="width: 100%">
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

                <div class="row mt-4" style="width: 100%">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active</h5>
                            <h6 class="card-subtitle m-2 text-muted">
                                Users with most posts written
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActive as $user)
                                    <li class="list-group-item">
                                        {{ $user->name }}
                                    </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row mt-4" style="width: 100%">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active Last Month</h5>
                            <h6 class="card-subtitle m-2 text-muted">
                                Users with most posts written in the month
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActiveLastMonth as $user)
                                    <li class="list-group-item">
                                        {{ $user->name }}
                                    </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection