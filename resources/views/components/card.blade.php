<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <h6 class="card-subtitle m-2 text-muted">
            {{ $subtitle }}
        </h6>
    </div>
    <ul class="list-group list-group-flush">
        @if (is_a($items, 'Illuminate\Support\Collection'))
            @foreach ($items as $item)
                @if (gettype($item) == "object")
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', ['post' => $item->id]) }}">
                            {{ $item->title }}
                        </a>
                    </li>
                @else
                    <li class="list-group-item">
                        {{ $item }}
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
</div>
