<?php
namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanTableMixCommand extends Command
{
    protected static $defaultName = 'app:mix:clean';
    private $em;
    private $input;
    private $output;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->mysql = $this->em->getConnection() ;


        $mixs = $this->mysql->fetchAll('select * from les_mix_0');
        $nMixs = count($mixs);
        
        foreach ($mixs as $key => $value) {
            // $sth = $this->mysql->prepare("UPDATE `les_mix_0` SET `image` = 'abc/91221275.jpg', `lienAudio` = 'abc/FLUME - Insane feat. Moon Holiday.mp3' WHERE `les_mix_0`.`id` = 1");
            // $sth->execute();

            $picture = basename($value['image']);
            $audioLink = basename($value['lienAudio']);

            $this->output->writeln("<info> ".$value['id']." => image: $picture  lienAudio: $audioLink </info>");
        }


        

        $this->output->writeln("<info> Fin du programme de test  $nMixs</info>");

        return 0;
    }
}