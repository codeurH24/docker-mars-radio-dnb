<?php

namespace App\Controller;

use App\Repository\AudioFileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\Request;

class MusicController extends AbstractController
{
    /**
     * @Route("/musiques", name="music")
     * @Route("/musiques/p/{page}", name="music_page")
     */
    public function index(AudioFileRepository $fileRepo, PaginatorInterface $paginator, $page=1)
    {
        // dd('stop');
        // récupere tout les mixs
        $files = $fileRepo->findBy(
            [],
            ['id' => 'DESC']
        );
        
        $mixs = $paginator->paginate(
            $files, // calcule le nombre d'item total
            $page, // numero de page demandé
            25 // nombre de résultats affiché par page
        );
        // Nombre de liens affichés dans la pagnination
        $mixs->setPageRange(10);
        $mixs->setUsedRoute('music_page');
        

        // généaration des anciens liens des boutons j'aime
        $title_fb_like[] = [];
        foreach ($files as $key => $row) {
            $title_fb_like[] = $this->transform_titre_track_for_url($row->getTitle());
        }

        return $this->render('music/index.html.twig', [
            'audioFiles' =>  $mixs,
            'title_fb_like' => $title_fb_like
        ]);
    }

    /**
     * @Route("/musiques/search/", name="music_search")
     * @Route("/musiques/search/{page}/", name="music_page_search")
     */
    public function search(Request $request, AudioFileRepository $fileRepo, PaginatorInterface $paginator, $page=1)
    {

        $slugify = new Slugify();
        $q = $request->query->get('q');
        // $r = explode(' ', $q);
        // dd($r);

        // récupere tout les mixs de la recherche
        $files = $fileRepo->search($q);
        

        $mixs = $paginator->paginate(
            $files, // calcule le nombre d'item total
            $page, // numero de page demandé
            5 // nombre de résultats affiché par page
        );
        // Nombre de liens affichés dans la pagnination
        $mixs->setPageRange(10);
        $mixs->setUsedRoute('music_page_search');
        

        // généaration des anciens liens des boutons j'aime
        $title_fb_like[] = [];
        foreach ($files as $key => $row) {
            $title_fb_like[] = $this->transform_titre_track_for_url($row->getTitle());
        }

        return $this->render('music/index.html.twig', [
            'audioFiles' =>  $mixs,
            'title_fb_like' => $title_fb_like,
            'search_query' => $q
        ]);
    }


    /**
     * @Route("/musiques/title/{title}", name="music_title_slug")
     */
    public function titleSlug(Request $request, AudioFileRepository $fileRepo, PaginatorInterface $paginator, $page=1, $title)
    {
        $slugify = new Slugify();
        $titleSlug = $slugify->slugify($title);
        // dd($titleSlug);
        //dj-lion-l-fete-de-la-musique
        // récupere tout les mixs de la recherche
        $files = $fileRepo->findAll();


        foreach ($files as $key => $row) {
            
            if ($slugify->slugify($title) === $slugify->slugify($row->getTitle())) {
                dd('trouvé');
            }
            dump(   $slugify->slugify($title)." === ".$slugify->slugify($row->getTitle())   );
        }

        

        $mixs = $paginator->paginate(
            $files, // calcule le nombre d'item total
            $page, // numero de page demandé
            5 // nombre de résultats affiché par page
        );
        // Nombre de liens affichés dans la pagnination
        $mixs->setPageRange(10);
        $mixs->setUsedRoute('music_page_search');
        

        // généaration des anciens liens des boutons j'aime
        $title_fb_like[] = [];
        foreach ($files as $key => $row) {
            $title_fb_like[] = $this->transform_titre_track_for_url($row->getTitle());
        }

        return $this->render('music/index.html.twig', [
            'audioFiles' =>  $mixs,
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
