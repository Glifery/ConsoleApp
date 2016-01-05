<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;

class LegacyCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('test:legacy')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('!!!!!!!!!');
//        system('clear');
        system('reset');
//        $output->write("\x0D");
        $output->writeln('----444444444');
//        $output->write("\x20");
        $output->write('----444444444');
//        sleep(1);
//        sleep(1);
        $output->writeln('----555');

        $table = new Table($output);
        $table
            ->setHeaders(array('ISBN22222222', 'Title', 'Author'))
            ->setRows(array(
                    array('99921-58-10-7', 'Divine Comedy', 'Dante Alighieri'),
                    array('9971-5-0210-0', 'A Tale of Two Cities', 'Charles Dickens'),
                    array('960-425-059-0', 'The Lord of the Rings', 'J. R. R. Tolkien'),
                    array('80-902734-1-6', 'And Then There Were None', 'Agatha Christie'),
                ))
        ;
        $table->render();


        $process = new Process('ls -lsa');
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output->writeln($process->getOutput());


//        shell_exec('stty -icanon');

//        system("stty -icanon");
        echo "input# \n";
        echo shell_exec('tput cols');
        echo "input# ";
        while ($c = fread(STDIN, 4096)) {
            $output->write("\x0D");
//            $output->write('                     ');
//            $output->writeln('');
//            echo "Read from STDIN: ()\n";
//            echo "                   ";
//            $output->write(sprintf("\033[%dA", '1234567890'));
            $output->write("\033[100A");
            $output->writeln('');
            $output->writeln('');
            $output->writeln('');
            $output->writeln('');
            $output->writeln('1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111');
        }

        $helper = $this->getHelper('question');
        $question = new Question('Please enter the name of the bundle', 'AcmeDemoBundle');
        $bundle = $helper->ask($input, $output, $question);
        $output->writeln('fff: '.$bundle);

        $output->writeln($bundle);

        // Reset the tty back to the original configuration
        $term = `stty -g`;
        system("stty '" . $term . "'");

        return 0;
    }
}