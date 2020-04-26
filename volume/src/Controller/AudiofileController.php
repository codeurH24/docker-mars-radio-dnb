<?php

namespace App\Controller;

use App\Entity\Audiofile;
use App\Form\AudiofileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @Route("/admin/audiofile")
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
            ->findBy([], ['id' => 'DESC']);

        return $this->render('audiofile/index.html.twig', [
            'audiofiles' => $audiofiles,
        ]);
    }

    /**
     * @Route("/new", name="audiofile_new", methods={"GET","POST"})
     */
    public function new(Request $request, KernelInterface $appKernel): Response
    {
        
        $audiofile = new Audiofile();
        $form = $this->createForm(AudiofileType::class, $audiofile);







        $form->handleRequest($request);
        
        if ($form->isSubmitted() /*&& $form->isValid()*/) {

            // dd($appKernel->getProjectDir());
            $root = $appKernel->getProjectDir();

            $entityManager = $this->getDoctrine()->getManager();
            $slugify = new Slugify();


            if ($request->get('audiofile') !== null) {
                // recupere le tableau de valeurs des inputs du formulaire
                $input = $request->get('audiofile');
                // tranforme le tableau de "genre" envoyé pas case coché en
                // un chaine
                $input['genre'] = implode ( ' - ' , $input['genre']);
                // modifie la valeur POST[genre] en une chaine
                // $request->attributes->set('audiofile', $input);
                $request->request->set('audiofile', $input);
                // dd($request);
            }



            // if ($request->get('audiofile') !== null) {
            //     dd($request->get('audiofile'));

            //     // $request->get('audiofile')$audiofile->setGenre();
            //     // dd($audiofile->getGenre());
            // }
            
            
            $nextId = $this->getNextId("AudioFile");

            $mixFileInfo = pathinfo($audiofile->getFilename());
            $slug_mix_name = $slugify->slugify($mixFileInfo['filename']);
            

            $img_file = $form->get('picture')->getData();
            $pictureName = $slugify->slugify($nextId.'-'.$mixFileInfo['filename']).'.'.$img_file->guessExtension();

            
            $mix_name = $slugify->slugify($nextId.'-'.$slug_mix_name).'.'.$mixFileInfo['extension'];
            $pathSource = $root.'/upload/mix/'.$audiofile->getFilename();
            $pathDest = $root.'/public/static/mix/'.$mix_name;
            
            if (file_exists($pathSource)) {
                
                if (!rename($pathSource, $pathDest)) {
                    dd("déplacement vers $pathDest erreur");
                } else
                    $audiofile->setFilename($mix_name);
            }

            $img_file->move(
                $this->getParameter('upload_img_directory'),
                $pictureName
            );
            $audiofile->setPicture($pictureName);

            
            $audiofile->setFileCreatedAt(new \Datetime());
            $audiofile->setFilesize(filesize($pathDest));


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
            $em = $this->getDoctrine()->getManager();
            $em->flush();
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
    public function delete(Request $request, Audiofile $audiofile, KernelInterface $appKernel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$audiofile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $root = $appKernel->getProjectDir();
            $pathDest = $root.'/public/static/mix/'.$audiofile->getFilename();
            if (file_exists($pathDest)) {
                if (!unlink($pathDest)) {
                    dd('Le fichier mix n\'est pas supprimé');
                }
            } else {
                dd('Le fichier mix n\'existe pas');
            }

            $pathDest = $root.'/public/static/image/mix/'.$audiofile->getPicture();
            if (file_exists($pathDest)) {
                if (!unlink($pathDest)) {
                    dd('Le fichier image n\'est pas supprimé');
                }
            } else {
                dd('Le fichier image n\'existe pas');
            }

            $entityManager->remove($audiofile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('audiofile_index');
    }


    private function getNextId($table) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        
        $sql = "
        SELECT `AUTO_INCREMENT`
        FROM  INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = '".$_ENV['DB_NAME']."'
        AND   TABLE_NAME   = '$table';
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch()['AUTO_INCREMENT'];
    }
}
