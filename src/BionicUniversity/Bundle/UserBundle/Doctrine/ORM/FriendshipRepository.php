<?php

namespace BionicUniversity\Bundle\UserBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;

class FriendshipRepository extends EntityRepository
{
    public function findFriendshipByUsers($firstUser, $secondUser)
    {
        $repository = $this->getEntityManager()->getRepository("BionicUniversityUserBundle:Friendship")->createQueryBuilder('friendship')
        ->where('(friendship.userSender = :firstUser AND friendship.userReceiver = :secondUser) OR (friendship.userSender = :secondUser AND friendship.userReceiver = :firstUser)')
        ->setParameter('firstUser', $firstUser)
        ->setParameter('secondUser',$secondUser)
        ->getQuery();

        return $repository->getSingleResult();
    }

    public function findFriends($user)
    {
        $repository = $this->getEntityManager()->getRepository("BionicUniversityUserBundle:Friendship")->createQueryBuilder('friendship')
            ->where('(friendship.userSender = :user OR friendship.userReceiver = :user) AND friendship.acceptanceStatus = 1')
            ->setParameter('user',$user)
            ->getQuery();

        return $repository->getResult();
    }

    public function findUnconfirmedFriends($userSender,$userReceiver)
    {
        $repository = $this->getEntityManager()->getRepository("BionicUniversityUserBundle:Friendship")->createQueryBuilder('friendship')
            ->where('friendship.userSender = :userSender AND friendship.userReceiver = :userReceiver AND friendship.acceptanceStatus != 1')
            ->setParameters(['userReceiver' => $userReceiver, 'userSender' => $userSender])
            ->getQuery();

        return $repository->getSingleResult();
    }
} 
