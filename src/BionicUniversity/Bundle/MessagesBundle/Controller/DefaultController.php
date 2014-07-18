<?php

namespace BionicUniversity\Bundle\MessagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BionicUniversityMessagesBundle:Default:index.html.twig', array('name' => $name));
    }
}
