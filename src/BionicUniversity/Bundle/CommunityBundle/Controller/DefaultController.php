<?php

namespace BionicUniversity\Bundle\CommunityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BionicUniversityCommunityBundle:Default:index.html.twig', array('name' => $name));
    }
}
