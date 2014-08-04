<?php

namespace BionicUniversity\Bundle\WallBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\UserBundle\Entity\Friendship;
use BionicUniversity\Bundle\CommunityBundle\Entity\Membership;
use BionicUniversity\Bundle\WallBundle\Entity\Post;

/**
 * Feed controller.
 */
class FeedController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        $feeds = $this->findFeed($user);

        return $this->render('BionicUniversityWallBundle:Feed:index.html.twig', array(
            'feeds' => $feeds,
        ));
    }

    public function findFeed($user)
    {
        $em = $this->getDoctrine()->getManager();

        $communities = $this->findCommunities($user);
        $friends = $this->findFriends($user);

        return $em->getRepository("BionicUniversityWallBundle:Post")->getFeed($communities, $friends, $user);
    }

    public function findCommunities($user)
    {
        $em = $this->getDoctrine()->getManager();
        $communities = $em->getRepository("BionicUniversityCommunityBundle:Community")
            ->createQueryBuilder('c')
            ->leftJoin('c.memberships', 'm')
            ->where('(m.user = :user)')
            ->setParameter('user', $user)
            ->getQuery();

        return $communities->getResult();
    }

    public function findFriends($user)
    {
        $em = $this->getDoctrine()->getManager();
        $friends = $em->getRepository("BionicUniversityUserBundle:User")
            ->createQueryBuilder('user')
            ->leftJoin('user.requests', 'request')
            ->leftJoin('user.invites', 'invite')
            ->where('(request.userReceiver = :user OR invite.userSender = :user) AND request.acceptanceStatus = 1 AND invite.acceptanceStatus = 1')
            ->setParameter('user', $user)
            ->getQuery();

        return $friends->getResult();
    }
}
