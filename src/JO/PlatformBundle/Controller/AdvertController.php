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
		return $this->render('JOPlatformBundle:Advert:view.html.twig', array('id' => $id));
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
		
		// TODO Return announce list
		return $this->render('JOPlatformBundle:Advert:index.html.twig');
    }
	
	// gestion du formulaire d'ajout d'annonces
	public function addAction(Request $request)
	{
		if ($request->isMethod('POST')){
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
			return $this->redirect($this->generateUrl('jo_platform_view', array('id' => 5)));
		}
		return $this->render('JOPlatformBundle:Advert:add.html.twig');
	}

	public function editAction($id, Request $request)
	{
		if ($request->isMethod('POST'))
		{
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifée');
			
			return $this->redirect($this->generateUrl('jo_platform_view', array('id'=>5)));
		}
		return $this->render('JOPlatformBundle:Advert:edit.html.twig');
	}
	
	public function deleteAction($id)
	{
		return $this->render('JOPlatformBundle:Advert:delete.html.twig');
	}
	
	public function byebyeAction()
	{
        $content = $this->get('templating')->render('JOPlatformBundle:Advert:index.html.twig', array('nom' => 'Joseph'));
		return new Response($content);
	}
}