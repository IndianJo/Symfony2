<?php

// src/JO/PlatformBundle/Controller/AdvertController.php

namespace JO\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends Controller
{
	// récupération de l'annonce correspondant a l'id
    public function viewAction($id)
	{
		$advert = array(
		  'title'   => 'Recherche développpeur Symfony2',
		  'id'      => $id,
		  'author'  => 'Alexandre',
		  'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
		  'date'    => new \Datetime()
		);
		return $this->render('JOPlatformBundle:Advert:view.html.twig', array('advert'=>$advert));
	}
	
	// On récupère tous les paramètres en arguments de la méthode
    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response("On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$_format.".");
    }
	
	// Récupération de la liste des annonces puis envois template
	public function indexAction($page)
    {
        // throw error in case of bad page number.
		if ($page <1)
			throw new NotFoundHttpException('Page "'.$page.'" inexistante.');


		// Notre liste d'annonce en dur
		$listAdverts = array(
		  array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => 1,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
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
			'date'    => new \Datetime())
		);

		// TODO Return announce list
		return $this->render('JOPlatformBundle:Advert:index.html.twig', array('listAdverts'=> $listAdverts));//array()));
    }
	
	// gestion du formulaire d'ajout d'annonces
	public function addAction(Request $request)
	{
		if ($request->isMethod('POST')){
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
			return $this->redirect($this->generateUrl('jo_platform_view', array('id' => 5)));
		}
		$advert = array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => 2,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'    => new \Datetime());

		return $this->render('JOPlatformBundle:Advert:add.html.twig', array('advert'=> $advert));
	}

	public function editAction($id, Request $request)
	{
		if ($request->isMethod('POST'))
		{
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifée');
			
			return $this->redirect($this->generateUrl('jo_platform_view', array('id'=>5)));
		}
		
		$advert = array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => $id,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'    => new \Datetime());
			
		return $this->render('JOPlatformBundle:Advert:edit.html.twig', array('advert'=>$advert));
	}
	
	public function deleteAction($id)
	{
		$advert = array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => $id,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'    => new \Datetime());
			
		return $this->render('JOPlatformBundle:Advert:delete.html.twig', array('advert'=>$advert));
	}
	
	public function byebyeAction()
	{
        $content = $this->get('templating')->render('JOPlatformBundle:Advert:index.html.twig', array('listAdverts'=> array()));
		return new Response($content);
	}
	
	public function menuAction($limit)
	{
		// On fixe en dur une liste ici, bien entendu par la suite
		// on la récupérera depuis la BDD !
		$listAdverts = array(
			array('id' => 2, 'title' => 'Recherche développeur Symfony2'),
			array('id' => 5, 'title' => 'Mission de webmaster'),
			array('id' => 9, 'title' => 'Offre de stage webdesigner')
		);

		return $this->render('JOPlatformBundle:Advert:menu.html.twig', array(
		// Tout l'intérêt est ici : le contrôleur passe
		// les variables nécessaires au template !
		'listAdverts' => $listAdverts));
	}
}