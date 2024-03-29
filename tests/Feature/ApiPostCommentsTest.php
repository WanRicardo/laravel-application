<?php
namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiPostCommentsTest extends TestCase
{
    use RefreshDatabase;
    
    public function testNewBlogPostDoesNotHaveComments()
    {
        $this->set1BlogPost();

        $response = $this->json('GET', 'api/v1/posts/1/comments');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(0, 'data');
    }
    
    public function testBlogPostHas10Comments()
    {
        $this->set1BlogPost()
        ->each(function (BlogPost $post) {
            $post->comments()->saveMany(
                Comment::factory(10)->make([
                    'user_id' => $this->user()->id
                ])
            );
        });

        $response = $this->json('GET', 'api/v1/posts/2/comments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' =>[
                    '*' => [
                        'id',
                        'content',
                        'created_at',
                        'updated_at',
                        'user' => [
                            'id',
                            'name'
                        ]
                    ]
                ], 
                'links', 
                'meta'
            ])
            ->assertJsonCount(10, 'data');
    }

    public function testAddingCommentsWhenNotAuthenticated()
    {
        $this->set1BlogPost();

        $response = $this->json('POST', 'api/v1/posts/3/comments', [
            'content' => 'Hello'
        ]);

        // $response->assertStatus(401);
        $response->assertUnauthorized();
    }

    public function testAddingCommentsWhenAuthenticated()
    {
        $this->set1BlogPost();

        $response = $this->actingAs($this->user(), 'api')->json('POST', 'api/v1/posts/3/comments', [
            'content' => 'Hello'
        ]);

        $response->assertStatus(201);
        // $response->assertUnauthorized();
    }
}
