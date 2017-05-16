<?php
/**
 * Created by PhpStorm.
 * User: Behnoush
 * Date: 16/05/2017
 * Time: 23:02
 */

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
    public  function indexAction()
    {
        $content = $this
            ->get('templating')
            ->render('OCPlatformBundle:Advert:index.html.twig', ['nom' => 'winzou']);

        return new Response($content);
    }
}