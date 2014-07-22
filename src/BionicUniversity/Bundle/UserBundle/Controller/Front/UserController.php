<?php
namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function profileAction($id)
    {
        return $this->render('BionicUniversityUserBundle:User/Front:profile.html.twig');
    }
}
