<p>
    @if (sizeof($tags) > 0)
        @foreach ($tags as $tag)
            <a href="{{ route('posts.tags.index', ['tag' => $tag->id]) }}" class="badge badge-success badge-lg">{{ $tag->name }}</a>
        @endforeach
    @endif
</p>