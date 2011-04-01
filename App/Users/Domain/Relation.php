<?php

namespace App\Users\Domain;

class Relation
{
    private static $retrievers = array();

    public function __construct()
    {
    }

    public function registerRetriever($retriever)
    {
        $retrieverName = get_class($retriever);
        self::$retrievers[$retrieverName] = $retriever;
        return $this;
    }

    public static function __callStatic($name, $arguments)
    {
        $retrieverName = 'App\Users\Domain\Retriever\\' . ucfirst($name) . 'Retriever';
        return self::$retrievers[$retrieverName];
    }
}