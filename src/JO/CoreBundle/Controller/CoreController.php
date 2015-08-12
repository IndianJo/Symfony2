<?php
// src/JO/CoreBundle/Controller/CoreController.php

namespace JO\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function IndexAction()
    {
        return $this->render('JOCoreBundle:Core:index.html.twig');
    }

    public function ContactAction()
    {
        return $this->render('JOCoreBundle:Core:contact.html.twig');
    }
}