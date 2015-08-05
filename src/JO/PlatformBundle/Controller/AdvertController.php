<?php

// src/JO/PlatformBundle/Controller/AdvertController.php

namespace JO\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends Controller
{
	public function addAction(Request $request)
	{
	  $session = $request->getSession();
	   
	  // Bien sûr, cette méthode devra réellement ajouter l'annonce
	   
	  // Mais faisons comme si c'était le cas
	  $session->getFlashBag()->add('info', 'Annonce bien enregistrée');

	  // Le « flashBag » est ce qui contient les messages flash dans la session
	  // Il peut bien sûr contenir plusieurs messages :
	  $session->getFlashBag()->add('info', 'Oui oui, il est bien enregistré !');

	  // Puis on redirige vers la page de visualisation de cette annonce
	  return $this->redirect($this->generateUrl('jo_platform_view', array('id' => 5)));
	}

    public function viewAction($id, Request $request)
	{
		return $this->render('JOPlatformBundle:Advert:view.html.twig', array('id' => $id));
	}
	
	// On récupère tous les paramètres en arguments de la méthode
    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response("On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$_format.".");
    }
	
	public function indexAction($page)
    {
        $url = $this->get('router')->generate('jo_platform_view', array('id'=>5));
		return new Response("L'url de l'annonce d'id 5 est : ".$url);
    }
	
	public function byebyeAction()
	{
        $content = $this->get('templating')->render('JOPlatformBundle:Advert:index.html.twig', array('nom' => 'Joseph'));
		return new Response($content);
	}
}