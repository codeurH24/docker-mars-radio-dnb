<?php

namespace App\Controller;

use App\Repository\AudiFileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MusicController extends AbstractController
{
    /**
     * @Route("/musiques", name="music")
     */
    public function index(AudiFileRepository $fileRepo)
    {


        $files = $fileRepo->findAll();
        $files = array_slice($files, 0, 10); 
        
        $title_fb_like[] = [];
        foreach ($files as $key => $row) {
            $title_fb_like[] = $this->transform_titre_track_for_url($row->getTitle());
        }

        return $this->render('music/index.html.twig', [
            'audioFiles' =>  $files,
            'title_fb_like' => $title_fb_like
        ]);
    }

    // fonction récuperé de la v2. A revoir plus tard pour
    // ne plus l'utiliser.
    public function transform_titre_track_for_url( $name )
	{
		$name = str_replace( "-", "_" ,$name );
		$name = str_replace( " ", "-" ,$name );
		return  $name;
	}
}
