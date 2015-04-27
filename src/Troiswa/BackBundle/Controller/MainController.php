<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function tryAction()
    {
       // die('Je suis dans le controller');
       // return new Response('message');
        return $this->render('TroiswaBackBundle:Default:mapage.html.twig', ['prenom'=>'Matthieu']);
    }

    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $countActeur = $em->getRepository('TroiswaBackBundle:Acteurs')->countNbActeurs();
        $countHommes = $em->getRepository('TroiswaBackBundle:Acteurs')->countNbHommes();
        $countFemmes = $em->getRepository('TroiswaBackBundle:Acteurs')->countNbFemmes();
        $countFilm = $em->getRepository('TroiswaBackBundle:films')->countNbFilms();
        $bestFilm = $em->getRepository('TroiswaBackBundle:films')->BestFilms();
        $lastFilms = $em->getRepository('TroiswaBackBundle:films')->lastFilms();
        $genreFilms = $em->getRepository('TroiswaBackBundle:films')->genreFilms('test3');
        $countGenre = $em->getRepository('TroiswaBackBundle:genre')->countNbGenres();

        return $this->render('TroiswaBackBundle:Main:dashbord.html.twig', ['nbActeurs'=>$countActeur,
                                                                            'nbFilms'=>$countFilm,
                                                                            'nbGenres'=>$countGenre,
                                                                            'bestFilm'=>$bestFilm,
                                                                            'nbHommes'=>$countHommes,
                                                                            'nbFemmes'=>$countFemmes,
                                                                            'lastFilms'=>$lastFilms,
                                                                            'genreFilms'=>$genreFilms]);
    }
}

