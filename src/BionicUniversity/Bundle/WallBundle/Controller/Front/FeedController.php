<?php

namespace BionicUniversity\Bundle\WallBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\UserBundle\Entity\Friendship;
use BionicUniversity\Bundle\CommunityBundle\Entity\Membership;
use BionicUniversity\Bundle\WallBundle\Entity\Post;
use BionicUniversity\Bundle\UserBundle\Entity\User;

/**
 * Feed controller.
 */
class FeedController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        $feeds = $this->findFeed($user);

        return $this->render('@BionicUniversityWall/Post/Front/news_feed.html.twig', [
            'feeds' => $feeds,
        ]);
    }

    public function findFeed($user)
    {
        $em = $this->getDoctrine()->getManager();

        $communities = $this->findCommunities($user);
        $myFriendships = $em->getRepository("BionicUniversityUserBundle:Friendship")->findFriends($user);
        $friends = [];
        /**
         * @var Friendship $friendship
         */
        foreach ($myFriendships as $friendship) {
            if ($friendship->getUserReceiver() == $user) {
                array_push($friends, $friendship->getUserSender());
            } else {
                array_push($friends, $friendship->getUserReceiver());
            }

        }

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
}