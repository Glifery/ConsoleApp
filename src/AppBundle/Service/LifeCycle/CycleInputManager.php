<?php

namespace AppBundle\Service\LifeCycle;

use AppBundle\Exception\LifeCycle\CycleInputException;
use AppBundle\Model\LifeCycle\CycleEvent;
use AppBundle\Model\LifeCycle\KeySchema;

class CycleInputManager
{
    /** @var KeySchema */
    private $inputSchema;

    public function loadKeySchema(KeySchema $inputSchema)
    {
        $this->inputSchema = $inputSchema;
    }

    /**
     * @param CycleEvent $cycleEvent
     * @return bool
     * @throws CycleInputException
     */
    public function handleEventInput(CycleEvent $cycleEvent)
    {
        if (!$this->inputSchema) {
            throw new CycleInputException('Key Schema has not set.');
        }

        $isMatched = false;
        $schema = $this->inputSchema->getSchema();
        foreach ($schema as $symbol => $keyDescription) {
            if ($symbol !== $cycleEvent->getInputSymbol()) {
                continue;
            }

            $isMatched = true;

            $class = $keyDescription->getClass();
            $methodName = $keyDescription->getMethodName();

            if (!is_callable(array($class, $methodName))) {
                throw new CycleInputException('KeyControll method %s::%s not callable.', get_class($class), $methodName);
            }

            call_user_func_array(array($class, $methodName), [$cycleEvent, $keyDescription]);
        }

        return $isMatched;
    }
}