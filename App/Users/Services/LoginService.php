<?php

namespace App\Users\Services;

use Predis\Client;
use Doctrine\ORM\EntityManager;

class LoginService
{
    private $entityManager;	
    private $redis;
    
    public function __construct(EntityManager $entityManager, Client $redis)
    {
        $this->entityManager = $entityManager;
        $this->redis = $redis;
    }

    public function doLogin($userId)
    {
        $user = $this->entityManager->getRepository('App\Users\Domain\User')->find($userId);

        if (!$this->redis->exists('user_' . $userId . '_address')) {
            $addresses = $this->entityManager->getRepository('App\Users\Domain\Address')->findByUserId($userId);

            foreach ($addresses as $address) {
                $this->redis->hmset('user_' . $userId . '_address', $address->getId(), $address->getContent());
            }
        }

        return $user;
    }
}