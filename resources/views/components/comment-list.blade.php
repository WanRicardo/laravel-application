@forelse ($comments as $comment)
    <p>
        {{ $comment->content }},
    </p>
    <x-tags :tags="$comment->tags" />
    <x-updated action="" :date="$comment->created_at" name="{{ $comment->user->name }}" userId="{{ $comment->user->id }}" />
@empty
    <p>No comments yet!</p>
@endforelse