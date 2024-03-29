<?php

namespace Tests;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user()
    {
        return User::factory()->create();
    }

    protected function set1BlogPost()
    {
        return BlogPost::factory()->create([
            'user_id' => $this->user()->id
        ]);
    }
}
