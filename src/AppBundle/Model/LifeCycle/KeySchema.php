<?php

namespace AppBundle\Model\LifeCycle;

class KeySchema
{
    /**
     * @var KeyDescription[]
     */
    private $schema;

    public function __construct(array $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return KeyDescription[]
     */
    public function getSchema()
    {
        return $this->schema;
    }
}