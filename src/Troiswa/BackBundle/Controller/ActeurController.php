<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
use Troiswa\BackBundle\Entity\Acteurs;

class ActeurController extends Controller
{

    public function acteurAction(Request $request)
    {
        /*$touslesActeur = [
            ['id'=>1,
            'prenom'=>'tom',
            'nom'=>'cruise',
            'sexe'=>0],
            ['id'=>2,
            'prenom'=>'richard',
            'nom'=>'dean Anderson',
            'sexe'=>1]];*/
        $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
        //$em: entity manager= $connexion dans le projet blog
        $touslesActeur= $em->getRepository('TroiswaBackBundle:Acteurs')->findAll();

        $em2   = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM TroiswaBackBundle:Acteurs a";
        $query = $em2->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $paginationActeur = $paginator->paginate(
            $touslesActeur,
            $request->query->get('page',1),
            5
        );


        return $this->render('TroiswaBackBundle:Main:acteurs.html.twig', ['acteurs'=>$paginationActeur]);
    }

    public function informationAction($id)  {
        /*$touslesActeur = [
            ['id'=>1, 'prenom'=>'tom', 'nom'=>'cruise', 'sexe'=>0],
            ['id'=>2, 'prenom'=>'richard', 'nom'=>'dean Anderson', 'sexe'=>1]
        ];
        foreach ($touslesActeur as $key => $value)    {
            if ($value['id'] == $id)    {
                $unActeur = [
                    'id'=>$value['id'],
                    'prenom'=>$value['prenom'],
                    'nom'=>$value['nom'],
                    'sexe'=>$value['sexe']
                ];
            }
        }
        */
        $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
        $unActeur = $em->getRepository('TroiswaBackBundle:Acteurs')->find($id);
        $filmographie = $em->getRepository('TroiswaBackBundle:Acteurs')->filmographie($id);
        if (empty($unActeur)) {
            throw $this->createNotFoundException('Cet acteur n\'existe pas');
        }
        return $this->render('TroiswaBackBundle:Main:acteur.html.twig', ['acteur'=>$unActeur,'filmographie'=>$filmographie]);
    }

    public function maxActeurAction()
    {
        $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
        $touslesActeur= $em->getRepository('TroiswaBackBundle:Acteurs')->findAll();
        return new Response(count($touslesActeur));
    }

    public function creerAction(Request $request)   {
        $newGenre = new Acteurs();
        $form = $this->createFormBuilder($newGenre)
            ->add('sexe', 'choice', array(
                'choices' => array('0' => 'Femme', '1' => 'Homme')
                ,'expanded'=>true,
                'data' => '0'))
            ->add('prenom', 'text')
            ->add('nom', 'text')
            ->add('dateNaissance', 'date', ['years'=>range(date('Y')-100,date('Y'))])
            ->add('ville', 'text')
            ->add('biographie', 'textarea')
            ->add('fichier', 'file',
                [
                    'constraints'=>new NotBlank(
                        ['message'=>'Une image doit être choisie']
                    )
                ])
            ->add('liaisonFilm', 'entity', array(
                'class' => 'TroiswaBackBundle:films',
                'property' => 'titre',
                'multiple'=>true))
            ->add('creer', 'submit')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid())   {
            $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
            $newGenre->upload();
            $em->persist($newGenre);
            $em->flush();
            $sessions = $request->getSession();
            $sessions->getFlashBag()->add('success_genre', 'L\'acteur a bien été ajouté');
            return $this->redirect($this->generateUrl('troiswa_back_acteurs'));
        }
        return $this->render('TroiswaBackBundle:Main:acteur_creation.html.twig', ['formGenre'=>$form->createView()]);
    }

    public function modifierAction($id, Request $request)   {
        $em = $this->getDoctrine()->getManager();
        $newGenre = $em->getRepository('TroiswaBackBundle:Acteurs')->find($id);
        $form = $this->createFormBuilder($newGenre)
            ->add('sexe', 'choice', array(
                'choices' => array('0' => 'Femme', '1' => 'Homme')
            ,'expanded'=>true))
            ->add('prenom', 'text')
            ->add('nom', 'text')
            ->add('dateNaissance', 'date')
            ->add('ville', 'text')
            ->add('biographie', 'textarea')
            ->add('fichier', 'file',
                [
                    'constraints'=>new NotBlank(
                        ['message'=>'Une image doit être choisie']
                    )
                ])
            ->add('liaisonFilm', 'entity', array(
                'class' => 'TroiswaBackBundle:films',
                'property' => 'titre',
                'multiple'=>true))
            ->add('modifier', 'submit')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid())   {
            $em = $this->getDoctrine()->getManager(); //recuperation de doctrine
            $em->persist($newGenre);
            $em->flush();
            $sessions = $request->getSession();
            $sessions->getFlashBag()->add('success_genre', 'L\'acteur a bien été modifié');
            return $this->redirect($this->generateUrl('troiswa_back_acteurs'));
        }
        // }
        return $this->render('TroiswaBackBundle:Main:acteur_modif.html.twig', ['formGenre'=>$form->createView()]);
    }

    public function supprimerAction($id, Request $request)   {
        $em = $this->getDoctrine()->getManager();
        $newGenre = $em->getRepository('TroiswaBackBundle:Acteurs')->find($id);

        $em->remove($newGenre);
        $em->flush();
        $sessions = $request->getSession();
        $sessions->getFlashBag()->add('success_genre', 'L\'acteur a bien été supprimé');
        return $this->redirect($this->generateUrl('troiswa_back_acteurs'));
    }
}

