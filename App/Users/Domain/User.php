<?php

namespace App\Users\Domain;

use App\Users\Domain\Retriever\RetrieverInterface;

/**
 * @Entity(repositoryClass="App\Users\Repositories\UserRepository")
 * @Table(name="user")
 */
class User
{
    /**
     * @Id @Column(type="integer",name="user_id")
     * @GeneratedValue
     */
    private $id;

    /** @Column(length=255,name="user_name") */
    private $name;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function lookup(RetrieverInterface $retriever)
    {
        $retriever->setUser($this);
        return $retriever;
    }
}