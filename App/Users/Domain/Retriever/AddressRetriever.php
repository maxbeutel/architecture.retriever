<?php

namespace App\Users\Domain\Retriever;

use Countable;
use Predis\Client;
use App\Users\Domain\User;

class AddressRetriever implements Countable, RetrieverInterface
{
    private $redis;

    private $user;

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function count()
    {
        return $this->redis->hlen('user_' . $this->user->getId() . '_address');
    }
}