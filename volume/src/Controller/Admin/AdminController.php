<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request)
    {
        
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


    /**
     * @Route("/admin/musique", name="admin_music")
     */
    public function adminMusic(Request $request)
    {

        // $router = $this->get("router");
        // $route = $router->match($request->getPathInfo());
        // dd($route);

        // dd($request->getUri());
        return $this->render('admin/music.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

}
