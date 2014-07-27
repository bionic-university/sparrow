<?php
namespace BionicUniversity\Bundle\CommunityBundle\Controller\Front;

use BionicUniversity\Bundle\CommunityBundle\Entity\Membership;
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
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $myMemberships = $em->getRepository('BionicUniversityCommunityBundle:Membership')->findByUser($user);
        $all = $em->getRepository('BionicUniversityCommunityBundle:Community')->findAll();
        $allCommunities=array();
        foreach ($all as $community)
        {
            foreach($myMemberships as $membership)
            {
                if($community->getId() != $membership->getCommunity()->getId())
                {
                    array_push($allCommunities,$community);
                }
            }
        }

        return $this->render('BionicUniversityCommunityBundle:Community/Front:communities.html.twig', array('my_memberships'=>$myMemberships,'all_communities'=>$allCommunities));
    }

    public function joinAction($id)
    {
        $entity = new Membership();
        $entity->setUser($this->getUser());
        $em = $this->getDoctrine()->getManager();

        $community = $em->getRepository('BionicUniversityCommunityBundle:Community')->findOneById($id);
        $entity->setCommunity($community);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('communities'));
    }

    public function leaveAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $membership = $em->getRepository('BionicUniversityCommunityBundle:Membership')->findOneById($id);

        $em->remove($membership);
        $em->flush();

        return $this->redirect($this->generateUrl('communities'));
    }
}
