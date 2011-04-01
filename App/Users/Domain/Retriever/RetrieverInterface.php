<?php

namespace App\Users\Domain\Retriever;

use App\Users\Domain\User;

interface RetrieverInterface
{
    function setUser(User $user);
}