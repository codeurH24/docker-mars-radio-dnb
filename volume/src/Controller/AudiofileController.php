<?php

namespace App\Controller;

use App\Entity\Audiofile;
use App\Form\AudiofileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/audiofile")
 */
class AudiofileController extends AbstractController
{
    /**
     * @Route("/", name="audiofile_index", methods={"GET"})
     */
    public function index(): Response
    {
        $audiofiles = $this->getDoctrine()
            ->getRepository(Audiofile::class)
            ->findAll();

        return $this->render('audiofile/index.html.twig', [
            'audiofiles' => $audiofiles,
        ]);
    }

    /**
     * @Route("/new", name="audiofile_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $audiofile = new Audiofile();
        $form = $this->createForm(AudiofileType::class, $audiofile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($audiofile);
            $entityManager->flush();

            return $this->redirectToRoute('audiofile_index');
        }

        return $this->render('audiofile/new.html.twig', [
            'audiofile' => $audiofile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="audiofile_show", methods={"GET"})
     */
    public function show(Audiofile $audiofile): Response
    {
        return $this->render('audiofile/show.html.twig', [
            'audiofile' => $audiofile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="audiofile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Audiofile $audiofile): Response
    {
        $form = $this->createForm(AudiofileType::class, $audiofile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('audiofile_index');
        }

        return $this->render('audiofile/edit.html.twig', [
            'audiofile' => $audiofile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="audiofile_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Audiofile $audiofile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$audiofile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($audiofile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('audiofile_index');
    }
}
