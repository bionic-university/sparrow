<?php
namespace BionicUniversity\Bundle\CommunityBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommunityController extends Controller
{
    public function profileAction($id)
    {
        return $this->render('BionicUniversityCommunityBundle:Community/Front:profile.html.twig');
    }
}
