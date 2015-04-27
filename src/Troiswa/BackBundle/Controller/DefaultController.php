<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TroiswaBackBundle:Default:index.html.twig', ['prenom'=>'Matthieu']);
    }
    public function tryAction()
    {
       // die('Je suis dans le controller');
       // return new Response('message');
        return $this->render('TroiswaBackBundle:Default:mapage.html.twig', ['prenom'=>'Matthieu']);
    }
}

