<?php

namespace App\Services;

use App\Contracts\CounterContract;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session;

class Counter implements CounterContract
{
    private $cache;
    private $session;
    private $timeout;
    private $supportsTags;

    public function __construct(Cache $cache, Session $session, int $timeout)
    {
        $this->cache = $cache;
        $this->session = $session;
        $this->timeout = $timeout;
        $this->supportsTags = method_exists($cache, 'tags');
    }

    public function increment(string $key, array $tags = null): int
    {
        // $sessionId = session()->getId();
        $sessionId = $this->session->getId();
        $counterKey = "{$key}-counter";
        $usersKey = "{$key}-users";

        $cache = $this->supportsTags && $tags != null ? $this->cache->tags($tags) : $this->cache; 

        // $users = Cache::tags(['blog-post'])->get($usersKey, []);
        $users = $cache->get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if($now->diffInMinutes($lastVisit) >= $this->timeout) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId]) >= $this->timeout) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        // Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);
        $cache->forever($usersKey, $usersUpdate);
        
        // if(!Cache::tags(['blog-post'])->has($counterKey)) {
        if(!$cache->has($counterKey)) {
            // Cache::tags(['blog-post'])->forever($counterKey, 1);
            $cache->forever($counterKey, 1);
        } else {
            // Cache::tags(['blog-post'])->increment($counterKey, $difference);
            $cache->increment($counterKey, $difference);
        }

        // $counter = Cache::tags(['blog-post'])->get($counterKey);
        $counter = $cache->get($counterKey);

        return $counter;
    }
}