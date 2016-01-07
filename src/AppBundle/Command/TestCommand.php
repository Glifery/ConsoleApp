<?php

namespace AppBundle\Command;

use AppBundle\Demo\DemoMovingHandler;
use AppBundle\Model\LifeCycle\KeySchemaBuilder;
use AppBundle\Model\Space\Object;
use AppBundle\Model\Space\Point;
use AppBundle\Model\Space\Window;
use AppBundle\Tool\Char;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('test:test')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $screenDrawer = $this->getContainer()->get('app.service.screen_drawer');
        $screenDrawer->initDraw($output);

        $screenExplorer = $this->getContainer()->get('app.service.screen_explorer');
        $rootWindow = $screenExplorer->createRootWindow();
        $object = $this->demoWindow($rootWindow);
        $screenDrawer->setRootWindow($rootWindow);

        $keySchema = KeySchemaBuilder::start()
            ->add(Char::ARROW_RIGHT, new DemoMovingHandler($object), 'moveRight')
            ->add(Char::ARROW_LEFT, new DemoMovingHandler($object), 'moveLeft')
            ->add(Char::ARROW_UP, new DemoMovingHandler($object), 'moveUp')
            ->add(Char::ARROW_DOWN, new DemoMovingHandler($object), 'moveDown')
            ->finish()
        ;
        $this->getContainer()->get('app.service.life_cycle.cycle_input_manager')->loadKeySchema($keySchema);

        $cycleLoop = $this->getContainer()->get('app.service.life_cycle.cycle_loop');
        $cycleLoop->run();
    }

    /**
     * @param Window $window
     * @return Object
     */
    private function demoWindow(Window $window)
    {
        $window->addObject(new Object\Border($window->getWidth(), $window->getHeight()));
        $window->setStyle(new OutputFormatterStyle('white', 'red'));

        $object = new Object();
        $object->setX(10);
        $object->setY(14);
        $window->addObject($object);

        $point = new Point('Q');
        $point->setX(-1);
        $point->setY(-1);
        $point->setStyle(new OutputFormatterStyle('red', 'yellow', array('bold', 'blink')));
        $object->addPoint($point);

        $point = new Point('D');
        $point->setX(1);
        $point->setY(0);
        $point->setStyle(new OutputFormatterStyle('red', 'black', array('underscore')));
        $object->addPoint($point);

        $point = new Point('Z');
        $point->setX(-1);
        $point->setY(1);
        $point->setStyle(new OutputFormatterStyle('red', 'yellow', array('bold')));
        $object->addPoint($point);

        $childWindow = new Window();
        $childWindow->setX(40);
        $childWindow->setY(20);
        $childWindow->setWidth(15);
        $childWindow->setHeight(15);
        $childWindow->addObject($object);
        $window->addChild($childWindow);
        $childWindow->addObject(new Object\Border($childWindow->getWidth(), $childWindow->getHeight()), '*');

        return $object;
    }
}
