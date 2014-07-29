<?php

namespace BionicUniversity\Bundle\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findFriendshipByUsers($firstUser, $secondUser)
    {
        $repository = $this->getEntityManager()->getRepository("BionicUniversityUserBundle:Friendship")->createQueryBuilder('friendship')
        ->where(('friendship.userSender' == $firstUser && 'friendship.userReceiver' == $secondUser) || ('friendship.userSender' == $secondUser && 'friendship.userReceiver' == $firstUser));

    }
} 