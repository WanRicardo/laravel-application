<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    // private $posts = [
    //     1 => [
    //         'title' => 'Intro to laravel',
    //         'content' => 'This is a short intro to Laravel',
    //         'is_new' => true,
    //         'has_comments' => true
    //     ],
    //     2 => [
    //         'title' => 'Intro to PHP',
    //         'content' => 'This is a short intro to PHP',
    //         'is_new' => false
    //     ],
    //     3 => [
    //         'title' => 'Intro to Golang',
    //         'content' => 'This is a short intro to Golang',
    //         'is_new' => false
    //     ]
    // ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $mostCommentedBlogPost = Cache::remember('blog-post-commented', now()->addSeconds(60), function() {
        //     return BlogPost::mostCommented()->take(5)->get();
        // });
        // $mostActive = Cache::remember('users-most-active', now()->addSeconds(60), function() {
        //     return User::withMostBlogPosts()->take(5)->get();
        // });
        // $mostActiveLastMonth = Cache::remember('users-most-active-last-month', now()->addSeconds(60), function() {
        //     return User::withMostBlogPostsLastMonth()->take(5)->get();
        // });
        // DB::enableQueryLog();

        // $posts = BlogPost::all();
        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post) {
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());
        return view(
            'posts.index',
            [
                'posts' => BlogPost::latest()->withCount('comments')->with('user')->with('tags')->get(),
                // 'mostCommented' => $mostCommentedBlogPost,
                // 'mostActive' => $mostActive,
                // 'mostActiveLastMonth' => $mostActiveLastMonth
            ]
        );
        // return view('posts.index', ['posts' => BlogPost::orderBy('created_at', 'desc')->take(5)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $storePost)
    {
        $validated = $storePost->validated();
        $validated['user_id'] = $storePost->user()->id;
        // $post = new BlogPost();
        // $post->title = $validated['title'];
        // $post->content = $validated['content'];
        // $post->save();

        $post = BlogPost::create($validated);
        // $post->fill($validated);

        $storePost->session()->flash('status', 'The blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function() use ($id) {
            return BlogPost::with('comments')->with('tags')->with('user')->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::tags(['blog-post'])->get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if($now->diffInMinutes($lastVisit) >= 1) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId]) >= 1) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);
        
        if(!Cache::tags(['blog-post'])->has($counterKey)) {
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        } else {
            Cache::tags(['blog-post'])->increment($counterKey, $difference);
        }

        $counter = Cache::tags(['blog-post'])->get($counterKey);

        // abort_if(!isset($this->posts[$id]), 404);

        // return view('posts.show', ['post' => BlogPost::with(['comments' => function($query) {
        //     return $query->latest();
        // }])->findOrFail($id)]);
        return view('posts.show', ['post' => $blogPost, 'counter' => $counter]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);
        // $this->authorize('update', $post);
        // $this->authorize('posts.update', $post);
        // if(Gate::denies('update-post', $post)){
        //     abort(403, "You can not edit this post");
        // }

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $storePost, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);
        // $this->authorize('update', $post);
        // $this->authorize('posts.update', $post);
        // if(Gate::denies('update-post', $post)){
        //     abort(403, "You can not edit this post");
        // }
        
        $validated = $storePost->validated();
        $post->fill($validated);
        $post->save();

        $storePost->session()->flash('status', 'Blog post was updated');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);
        // $this->authorize('delete', $post);
        // $this->authorize('posts.delete', $post);
        // if(Gate::denies('delete-post', $post)){
        //     abort(403, "You can not delete this post");
        // }

        $post->delete();

        session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}