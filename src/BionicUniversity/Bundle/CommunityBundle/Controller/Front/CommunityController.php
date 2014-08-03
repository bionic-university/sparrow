<?php
namespace BionicUniversity\Bundle\CommunityBundle\Controller\Front;

use BionicUniversity\Bundle\CommunityBundle\Entity\Membership;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\WallBundle\Entity\Post;
use BionicUniversity\Bundle\CommunityBundle\Form\Type\PostType;

use BionicUniversity\Bundle\UserBundle\Entity\User;
class CommunityController extends Controller
{

    public function profileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BionicUniversityCommunityBundle:Community')->find($id);
        $posts = $em->getRepository('BionicUniversityWallBundle:Post')->findByCommunity($entity, ['createdAt'=>'desc']);
        $memberships = $em->getRepository('BionicUniversityCommunityBundle:Membership')->findByCommunity($entity);
        $users = array();
        foreach($memberships as $membership)
        {
            $users[] = $membership->getUser();
        }
        if (!$users) {
            throw $this->createNotFoundException('Unable to find Users.');
        }
        if (!$memberships) {
            throw $this->createNotFoundException('Unable to find Memberships.');
        }
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createPostForm($id);

        return $this->render('BionicUniversityCommunityBundle:Community/Front:community.html.twig', array(
            'entity' => $entity,
            'post' => $posts,
            'form' => $form->createView(),
            'users' => $users,
        ));
    }

    public function communitiesAction()
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $myMemberships = $em->getRepository('BionicUniversityCommunityBundle:Membership')->findByUser($user);
        $all = $em->getRepository('BionicUniversityCommunityBundle:Community')->findAll();
        $allCommunities=array();

        if(null != $myMemberships)
        {
            foreach($all as $community => $data)
            {
                foreach($myMemberships as $membership)
                {
                    if($data->getId() === $membership->getCommunity()->getId())
                    {
                        unset($all[$community]);
                    }
                }
            }

        }

        $allCommunities=$all;

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

    /**
     * Creates a form to create communities posts.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createPostForm($id)
    {
        $form = $this->createForm(new PostType(), null, array(
            'action' => $this->generateUrl('create_community_post', ['id'=>$id]),
            'method' => 'POST',
            'show_legend' => true,
            'label' => 'Write a new post',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create new post',
            'attr' => ['class' => 'pull-right btn btn-success']));

        return $form;
    }
}