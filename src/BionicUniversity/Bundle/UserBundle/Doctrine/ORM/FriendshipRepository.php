<?php

namespace BionicUniversity\Bundle\UserBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;

class FriendshipRepository extends EntityRepository
{
    public function findFriendshipByUsers($firstUser, $secondUser)
    {
        $repository = $this->getEntityManager()->getRepository("BionicUniversityUserBundle:Friendship")->createQueryBuilder('friendship')
        ->where(('friendship.userSender' == $firstUser && 'friendship.userReceiver' == $secondUser) || ('friendship.userSender' == $secondUser && 'friendship.userReceiver' == $firstUser))
            ->getQuery();

        return $repository->getResult();

    }
} 
