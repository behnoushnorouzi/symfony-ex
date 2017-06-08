<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
  public function indexAction($page)
  {
    if ($page < 1) {
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }

    // Notre liste d'annonce en dur
    $listAdverts = array(
      array(
        'title'   => 'Recherche développpeur Symfony',
        'id'      => 1,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Mission de webmaster',
        'id'      => 2,
        'author'  => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 3,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 4,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 5,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime())
    );


    return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts,
    ));
  }

  public function viewAction($id)
  {
      //Model 1
      //$repository = $this->getDoctrine()->getManager()->getRepository('OCPlatformBundle:Advert');
      //$advert = $repository->find($id);

      //Model2
      $advert = $this->getDoctrine()->getManager()->find('OCPlatformBundle:Advert', $id);

      if(null === $advert){
          throw new NotFoundHttpException("L'annonce d'id ".$id."n'existe pas. ");
      }

    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
      'advert' => $advert
    ));
  }

  public function addAction(Request $request)
  {
    $advert = new Advert();

    $advert->setTitle('Recherche developeur Symfony');
    $advert ->setAuthor('Behnoush');
    $advert->setContent('Nous recherchons un développeur symfony débutant sur lyon.');
    $advert->setDate(new \DateTime("now"));
    $advert->setPublished(1);

    $image = new Image();
    $image->setUrl('http://www.geronimo-agency.com/wp-content/uploads/2016/02/Developper-application-mobile-m-commerce-790x500.jpg');
    $image->setAlt('developer');

    $advert->setImage($image);

    $em = $this->getDoctrine()->getManager();

    $em->persist($advert);
    $em->flush();

    if($request->isMethod('POST')){
        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

        return $this->redirectToRoute('oc_platform_view', ['id'=>$advert->getId()]);
    }

    return $this->render('OCPlatformBundle:Advert:add.html.twig', ['advert'=>$advert]);
  }

  public function editAction($id)
  {

    $em = $this->getDoctrine()->getManager();
    $advert = $em->find('OCPlatformBundle:Advert', $id);
    $advert->getImage()->setUrl('https://www.prestaconcept.net/medias/content/media/Symfony-logo_20160808115724.png');

    $em->flush();

    return new Response('OK');
  }

  public function deleteAction($id)
  {
    return $this->render('OCPlatformBundle:Advert:delete.html.twig');
  }

  public function menuAction($limit)
  {
    // On fixe en dur une liste ici, bien entendu par la suite on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }
}
