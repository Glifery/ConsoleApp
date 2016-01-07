<?php

namespace AppBundle\Model\LifeCycle;

use AppBundle\Exception\LifeCycle\CycleInputException;
use AppBundle\Tool\KeyControllInterface;

class KeySchemaBuilder
{
    /**
     * @var array[]
     */
    private $schema;

    public function __construct()
    {
        $this->schema = [];
    }

    /**
     * @return KeySchemaBuilder
     */
    public static function start()
    {
        return new self;
    }

    /**
     * @param string $symbol
     * @param KeyControllInterface $class
     * @param string $methodName
     * @param array $arguments
     * @return $this
     */
    public function add($symbol, KeyControllInterface $class, $methodName, array $arguments = [])
    {
        $this->schema[$symbol] = new KeyDescription($class, $methodName, $arguments);

        return $this;
    }

    /**
     * @return KeySchema
     * @throws CycleInputException
     */
    public function finish()
    {
        if (!count($this->schema)) {
            throw new CycleInputException('Key Schema Builder is empty.');
        }

        $keySchema = new KeySchema($this->schema);

        return $keySchema;
    }
}