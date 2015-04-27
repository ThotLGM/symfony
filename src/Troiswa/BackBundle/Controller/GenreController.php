<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Troiswa\BackBundle\Entity\genre;

class GenreController extends Controller
{

    public function genreAction()     {
        $em = $this->getDoctrine()->getManager();
        $tousLesGenres= $em->getRepository('TroiswaBackBundle:genre')->findAll();
        return $this->render('TroiswaBackBundle:Main:genres.html.twig', ['genres'=>$tousLesGenres]);
    }

    public function informationAction($id)  {

        $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
        $unGenre = $em->getRepository('TroiswaBackBundle:genre')->find($id);
        if (empty($unGenre)) {
            throw $this->createNotFoundException('Ce film n\'existe pas');
        }
        return $this->render('TroiswaBackBundle:Main:genre.html.twig', ['genre'=>$unGenre]);
    }

    public function maxGenreAction() {
        $em = $this->getDoctrine()->getManager();
        $tousLesGenres= $em->getRepository('TroiswaBackBundle:genre')->findAll();
        return new Response(count($tousLesGenres));
    }

    public function creerAction(Request $request)   {
        $newGenre = new Genre();
        $form = $this->createFormBuilder($newGenre)
            ->add('type', 'text')
            ->add('description', 'textarea')
            ->add('ajouter', 'submit')
            ->getForm();
        /*if ($request->isMethod('POST'))   {
            $form->submit($request);*/
        $form->handleRequest($request);

            if ($form->isValid())   {
                $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
                $em->persist($newGenre);
                //$newGenre->setType('toto');
                $em->flush();
                $sessions = $request->getSession();
                $sessions->getFlashBag()->add('success_genre', 'Le genre a bien été ajouté');
                return $this->redirect($this->generateUrl('troiswa_back_genres'));
            }
       // }
        return $this->render('TroiswaBackBundle:Main:genre_creation.html.twig', ['formGenre'=>$form->createView()]);
    }

    public function modifierAction($id, Request $request)   {
        //$newGenre = new Genre();
        $em = $this->getDoctrine()->getManager();
        $newGenre = $em->getRepository('TroiswaBackBundle:genre')->find($id);
        $form = $this->createFormBuilder($newGenre)
            ->add('type', 'text')
            ->add('description', 'textarea')
            ->add('modifier', 'submit')
            ->getForm();
        /*if ($request->isMethod('POST'))   {
            $form->submit($request);*/
        $form->handleRequest($request);

        if ($form->isValid())   {
            $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
            $em->persist($newGenre);
            $em->flush();
            $sessions = $request->getSession();
            $sessions->getFlashBag()->add('success_genre', 'Le genre a bien été modifié');
            return $this->redirect($this->generateUrl('troiswa_back_genres'));
        }
        // }
        return $this->render('TroiswaBackBundle:Main:genre_modif.html.twig', ['formGenre'=>$form->createView()]);
    }

    public function supprimerAction($id, Request $request)   {
        $em = $this->getDoctrine()->getManager();
        $newGenre = $em->getRepository('TroiswaBackBundle:genre')->find($id);

        $em->remove($newGenre);
        $em->flush();
        $sessions = $request->getSession();
        $sessions->getFlashBag()->add('success_genre', 'Le genre a bien été supprimé');
        return $this->redirect($this->generateUrl('troiswa_back_genres'));
    }
}

