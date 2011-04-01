<?php

namespace App\Users\Domain;

/**
 * @Entity(repositoryClass="App\Users\Repositories\AddressRepository")
 * @Table(name="address")
 */
class Address
{
    /**
     * @Id @Column(type="integer",name="address_id")
     * @GeneratedValue
     */
    private $id;

    /** @Column(length=255,name="address_content") */
    private $content;

    /** @Column(type="integer",name="user_id") */
    private $userId;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }
}