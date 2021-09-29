<div class="mb-2 mt-2">
    @auth
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <textarea type="text" id="content" class="form-control" name="content"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Add Comment!</button>
        </form>
    @else
        <a href="{{ route('login') }}">Sign-in</a> to post comments!
    @endauth
</div>
<hr>