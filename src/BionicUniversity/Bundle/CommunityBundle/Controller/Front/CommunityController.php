<?php
namespace BionicUniversity\Bundle\CommunityBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommunityController extends Controller
{
    public function profileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BionicUniversityCommunityBundle:Community')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        return $this->render('BionicUniversityCommunityBundle:Community/Front:community.html.twig', array('entity'=> $entity));
    }
    public function communitiesAction()
    {
        return $this->render('BionicUniversityCommunityBundle:Community/Front:communities.html.twig');
    }
}
