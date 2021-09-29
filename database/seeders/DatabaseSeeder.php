<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        if($this->command->confirm('Do you want to refresh database?')) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }

        Cache::tags(['blog-post'])->flush();
        
        $this->call([
            UsersTableSeeder::class,
            BlogPostsTableSeeder::class,
            CommentsTableSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();

        // $doe = User::factory()->new(['name' => 'Jhon Doe', 'email' => 'jhon@laravel.test', 'is_admin' => true])->create();
        // $else = User::factory(20)->create();

        // $users = $else->concat([$doe]);

        // $posts = BlogPost::factory(50)->make()->each(function($post) use ($users) {
        //     $post->user_id = $users->random()->id;
        //     $post->save();
        // });

        // $comments = Comment::factory(150)->make()->each(function($comment) use ($posts) {
        //     $comment->blog_post_id = $posts->random()->id;
        //     $comment->save();
        // });
    }
}
