<?php

namespace AppBundle\Command;

use AppBundle\Model\Space\Object;
use AppBundle\Model\Space\Point;
use AppBundle\Model\Space\Window;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
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
        $terminalDrawer = $this->getContainer()->get('app.service.terminal_drawer');
        $terminalDrawer->initDraw($output);

        $terminalExplorer = $this->getContainer()->get('app.service.terminal_explorer');
        $rootWindow = $terminalExplorer->createRootWindow();
        $childWindow = $this->demoWindow($rootWindow);
        $terminalDrawer->setRootWIndow($rootWindow);

        $output->writeln('1-'.$rootWindow->getWidth().'x'.$rootWindow->getHeight());
        $output->writeln('2-'.$rootWindow->getWidth().'x'.$rootWindow->getHeight());
        $output->writeln('3-'.$rootWindow->getWidth().'x'.$rootWindow->getHeight());
        $output->writeln('4-'.$rootWindow->getWidth().'x'.$rootWindow->getHeight());
        $terminalDrawer->redraw();
        while (true) {
            sleep(0.2);
            $childWindow->addX(1);
            $terminalDrawer->redraw();
        }
//        $output->write('d');
//        $output->writeln("\033[K");
    }

    /**
     * @param Window $window
     * @return Window
     */
    private function demoWindow(Window $window)
    {
        $object = new Object();
        $object->setX(10);
        $object->setY(15);
        $window->addObject($object);

        $point = new Point('Q');
        $point->setX(-1);
        $point->setY(-1);
        $object->addPoint($point);

        $point = new Point('D');
        $point->setX(1);
        $point->setY(0);
        $object->addPoint($point);

        $point = new Point('Z');
        $point->setX(-1);
        $point->setY(1);
        $object->addPoint($point);

        $childWindow = new Window();
        $childWindow->setX(40);
        $childWindow->setY(20);
        $childWindow->setWidth(15);
        $childWindow->setHeight(15);
        $childWindow->addObject($object);
        $window->addChild($childWindow);

        return $childWindow;
    }
} 