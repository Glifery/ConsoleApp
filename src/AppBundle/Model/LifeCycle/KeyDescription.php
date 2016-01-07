<?php

namespace AppBundle\Model\LifeCycle;

use AppBundle\Tool\KeyControllInterface;

class KeyDescription
{
    /** @var KeyControllInterface */
    private $class;

    /** @var string */
    private $methodName;

    /** @var array */
    private $arguments;

    /**
     * @param KeyControllInterface $class
     * @param string $methodName
     * @param array $arguments
     */
    public function __construct(KeyControllInterface $class, $methodName, array $arguments = [])
    {
        $this->class = $class;
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     * @return $this
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return KeyControllInterface
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param KeyControllInterface $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     * @return $this
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;

        return $this;
    }
}