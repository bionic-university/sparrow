<?php

namespace BionicUniversity\Bundle\UserBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class UserRepository extends EntityRepository
{
    public function findConversation($user)
    {
        $repository = $this->createQueryBuilder('user')
            ->leftJoin('user.outcomingMessages','o')
            ->leftJoin('user.incomingMessages', 'i')
            ->orWhere('i.fromUser =:user')
            ->orWhere('o.toUser=:user')
            ->orderBy('i.createdAt')
            ->orderBy('o.createdAt')
            ->setParameter('user',  $user)
            ->getQuery();

        return $repository->getResult();
    }
}
