<?php

namespace BionicUniversity\Bundle\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BionicUniversityWallBundle:Default:index.html.twig', array('name' => $name));
    }
}
