<?php
namespace App\Command;

use App\Entity\Audiofile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Cette commande est dépendant de app:mix:clean
 * qui remplis la table Audiofile. La commande app:picture:clean
 * utilise cette table remplis.
 */
class CleanPictureTableMixCommand extends Command
{
    protected static $defaultName = 'app:picture:clean';
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
        $dir_source = __DIR__."/../../old_picture/";
        $dir_dest =   __DIR__."/../../public/static/image/mix/";

        $this->mysql = $this->em->getConnection() ;

        $fp = fopen(__DIR__.'/../../var/log/app-picture-mix-clean.log', 'w');
        $fpError = fopen(__DIR__.'/../../var/log/app-picture-mix-clean-errors.log', 'w');
        

        $mixs = $this->em->getRepository(Audiofile::class)->findAll();
        $nMixs = count($mixs);
        $this->output->writeln("<info>Liste de $nMixs lignes</info>");
        
        foreach ($mixs as $key => $audiofile) {
            // dd($row);

            
            $oldName = $audiofile->getOldPictureName();
            
            // image extension
            $path_parts = pathinfo($oldName);
            $imageExt = $path_parts['extension'];
            
            // audio extension
            $path_parts = pathinfo($audiofile->getFilename());
            $audioExt = $path_parts['extension'];
            
            $newName = str_replace($audioExt, $imageExt, $audiofile->getFilename());
            $this->output->writeln("<info>Remplace Extension ".$audioExt." par ".$imageExt." = ".$newName."</info>");

            if (file_exists($dir_source.$oldName)) {

                $this->output->writeln("<info> Ok ".$dir_source.$oldName." </info>");

                if(copy($dir_source.$oldName, $dir_dest.$newName)) {
                    $this->output->writeln("<info> Copie vers ".$dir_dest.$newName." </info>\n");
                    $audiofile->setPicture($newName);
                    $this->em->persist($audiofile);
                    $this->em->flush();
                }

            } else {
                $this->output->writeln("<error>N'existe pas ".$dir_source.$oldName." </error>");
            }
        }
        
        fclose($fp);
        fclose($fpError);

        $this->output->writeln("<info> Fin du programme</info>");
        return 0;
    }



}
