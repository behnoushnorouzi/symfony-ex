<?php

namespace BN\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BNCoreBundle:Default:index.html.twig');
    }

    public function contactAction()
    {
        $session = new Session();
        $session->getFlashBag()->add('info', 'La page de contact n’est pas encore disponible');

        return $this->redirectToRoute('bn_core_homepage');


    }
}
