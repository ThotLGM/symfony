<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
use Troiswa\BackBundle\Entity\films;

class FilmController extends Controller
{

    public function filmAction()     {
        $em = $this->getDoctrine()->getManager();
        $tousLesFilms= $em->getRepository('TroiswaBackBundle:films')->findAll();
        return $this->render('TroiswaBackBundle:Main:films.html.twig', ['films'=>$tousLesFilms]);
    }

    public function informationAction($id)  {

        $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
        $unFilm = $em->getRepository('TroiswaBackBundle:films')->find($id);
        if (empty($unFilm)) {
            throw $this->createNotFoundException('Ce film n\'existe pas');
        }
        return $this->render('TroiswaBackBundle:Main:film.html.twig', ['film'=>$unFilm]);
    }

    public function maxFilmAction() {
        $em = $this->getDoctrine()->getManager();
        $tousLesFilms= $em->getRepository('TroiswaBackBundle:films')->findAll();
        return new Response(count($tousLesFilms));
    }

    public function creerAction(Request $request)   {
        $newGenre = new films()  ;
        $form = $this->createFormBuilder($newGenre)
            ->add('titre', 'text')
            ->add('description', 'textarea')
            ->add('dateDeRealisation', 'date', ['years'=>range(date('Y')-100,date('Y'))])
            ->add('note', 'number')
            ->add('fichier', 'file',
                [
                    'constraints'=>new NotBlank(
                        ['message'=>'Une image doit être choisie']
                    )
                ])
            ->add('liaisonGenre', 'entity', array(
                'class' => 'TroiswaBackBundle:genre',
                'property' => 'type'))
            ->add('creer', 'submit')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid())   {
            $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
            $newGenre->upload();
            $em->persist($newGenre);
            $em->flush();
            $sessions = $request->getSession();
            $sessions->getFlashBag()->add('success_film', 'Le film a bien été ajouté');
            return $this->redirect($this->generateUrl('troiswa_back_films'));
        }
        return $this->render('TroiswaBackBundle:Main:film_creation.html.twig', ['formGenre'=>$form->createView()]);
    }

    public function modifierAction($id, Request $request)   {
        $em = $this->getDoctrine()->getManager();
        $newGenre = $em->getRepository('TroiswaBackBundle:films')->find($id);
        $form = $this->createFormBuilder($newGenre)
            ->add('titre', 'text')
            ->add('description', 'textarea')
            ->add('dateDeRealisation', 'date', ['years'=>range(date('Y')-100,date('Y'))])
            ->add('note', 'number')
            ->add('fichier', 'file',
                [
                    'constraints'=>new NotBlank(
                        ['message'=>'Une image doit être choisie']
                    )
                ])
            ->add('liaisonGenre', 'entity', array(
                'class' => 'TroiswaBackBundle:genre',
                'property' => 'type'))
            ->add('modifier', 'submit')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid())   {
            $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
            $em->persist($newGenre);
            $em->flush();
            $sessions = $request->getSession();
            $sessions->getFlashBag()->add('success_film', 'Le film a bien été modifié');
            return $this->redirect($this->generateUrl('troiswa_back_films'));
        }
        // }
        return $this->render('TroiswaBackBundle:Main:film_modif.html.twig', ['formGenre'=>$form->createView()]);
    }

    public function supprimerAction($id, Request $request)   {
        $em = $this->getDoctrine()->getManager();
        $newGenre = $em->getRepository('TroiswaBackBundle:films')->find($id);

        $em->remove($newGenre);
        $em->flush();
        $sessions = $request->getSession();
        $sessions->getFlashBag()->add('success_film', 'Le film a bien été supprimé');
        return $this->redirect($this->generateUrl('troiswa_back_films'));
    }
}

