<?php

namespace AppBundle\Command;

use AppBundle\Model\Space\Object;
use AppBundle\Model\Space\Point;
use AppBundle\Model\Space\Window;
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

        $terminalExplorer = $this->getContainer()->get('app.service.terminal_explorer');
        $rootWindow = $terminalExplorer->createRootWindow();
        $childWindow = $this->demoWindow($rootWindow);
        $screenDrawer->setRootWindow($rootWindow);

        $output->writeln('1-'.$rootWindow->getWidth().'x'.$rootWindow->getHeight());
        $output->writeln('2-'.$rootWindow->getWidth().'x'.$rootWindow->getHeight());
        $output->writeln('3-'.$rootWindow->getWidth().'x'.$rootWindow->getHeight());
        $output->writeln('4-'.$rootWindow->getWidth().'x'.$rootWindow->getHeight());
        $screenDrawer->redraw();
        while (true) {
            sleep(1);
            $childWindow->addX(1);
            $screenDrawer->redraw();
        }

        new OutputFormatterStyle();
//        $output->write('d');
//        $output->writeln("\033[K");
    }

    /**
     * @param Window $window
     * @return Window
     */
    private function demoWindow(Window $window)
    {
        $window->addObject(new Object\Border($window->getWidth(), $window->getHeight()));

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

        return $childWindow;
    }
}
