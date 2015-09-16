<?php

// src/JO/PlatformBundle/Controller/AdvertController.php

namespace JO\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

use JO\PlatformBundle\Entity\Advert;
use JO\PlatformBundle\Entity\Image;
use JO\PlatformBundle\Entity\AdvertSkill;

class AdvertController extends Controller
{

	// récupération de l'annonce correspondant a l'id
    public function viewAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JOPlatformBundle:Advert');

		$advert = $repository->find($id);
		
		if($advert === null)
			throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas");
		
		//on récup la liste des application
		$listApplications = $em->getRepository('JOPlatformBundle:Application')->findBy(array('advert'=>$advert));
		// On récupère maintenant la liste des AdvertSkill
		$listAdvertSkills = $em->getRepository('JOPlatformBundle:AdvertSkill')->findBy(array('advert' => $advert));
    ;

		return $this->render('JOPlatformBundle:Advert:view.html.twig', array('advert'=>$advert, 'listApplications' => $listApplications, 'listAdvertSkills'=> $listAdvertSkills));
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
		
		// création de l'annonce
		$advert = new Advert();
		$advert->setTitle('Recherche développpeur Symfony2');
		$advert->setAuthor('Alexandre');
		$advert->setContent( 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…');

		//création de l'image
		$image = new Image();
		$image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
		$image->setAlt('Job de rêve');

		$em = $this->getDoctrine()->getManager();
		//$em->persist($image);

		//Ajout de l'image à l'annonce
		$advert->setImage($image);

		// Gestion des compétences
		$listSkills = $em->getRepository('JOPlatformBundle:Skill')->findAll();

		foreach ($listSkills as $skill) {
			// On crée une nouvelle « relation entre 1 annonce et 1 compétence »
			$advertSkill = new AdvertSkill();

			// On la lie à l'annonce, qui est ici toujours la même
			$advertSkill->setAdvert($advert);
			// On la lie à la compétence, qui change ici dans la boucle foreach
			$advertSkill->setSkill($skill);

			// Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
			$advertSkill->setLevel('Expert');

			// Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
			$em->persist($advertSkill);
  		}



		//on persiste l'entité (confie la gestion à doctrine)
		$em->persist($advert);
		
		// commit modification
		$em->flush();
		
		/*
		// récupération du service antispam
		$antispam = $this->container->get('jo_platform.antispam');
		
		//exempe d'utilisation du service
		$text = '...';
		if($antispam->isSpam($text))
		{
			throw new \Exception('Votre message a été détecté comme spam !');
		}*/
		return $this->render('JOPlatformBundle:Advert:add.html.twig', array('advert'=>$advert));
	}

	public function editAction($id, Request $request)
	{
		if ($request->isMethod('POST'))
		{
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifée');
			return $this->redirect($this->generateUrl('jo_platform_view', array('id'=>5)));
		}

		$em = $this->getDoctrine()->getManager();

		$advert = $em->getRepository('JOPlatformBundle:Advert')->Find($id);
		if ($advert === null)
			throw new NotFoundHttpException("L'annonce d'id ".$id." n'exist pas");

		// Récupération de toutes les catégories présente dans la base.
		$listCategories = $em->getRepository('JOPlatformBundle:Category')->findAll();
		
		// on lie les catégories à l'annonce.
		foreach ($listCategories as $category) {
			$advert->addCategory($category);
		}
		/*$advert = array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => $id,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'    => new \Datetime());
		*/
		
		$em->flush();

		return $this->render('JOPlatformBundle:Advert:edit.html.twig', array('advert'=>$advert));
	}
	
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$advert = $em->getRepository('JOPlatformBundle:Advert')->find($id);
		if ($advert === null)
			throw new NotFoundHttpException("L'annnce d'id ".$id." n'existe pas");

		foreach ($advert->getCategories() as $category) {
			$category->removeCategory();
		}
			
		$em->flush();
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

	public function tradAction($name)
	{
		return $this->render('JOPlatformBundle:Advert:translation.html.twig', array('name' => $name));
	}
}