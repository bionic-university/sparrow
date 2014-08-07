<?php

namespace BionicUniversity\Bundle\UserBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class UserRepository extends EntityRepository
{
    public function findConversation($user)
    {
        $repository = $this->createQueryBuilder('user')
            ->leftJoin('user.outcomingMessages', 'o')
            ->leftJoin('user.incomingMessages', 'i')
            ->orWhere('i.fromUser =:user')
            ->orWhere('o.toUser=:user')
            ->orderBy('i.createdAt')
            ->orderBy('o.createdAt')
            ->setParameter('user', $user)
            ->getQuery();

        return $repository->getResult();
    }

    public function search(array $tokens)
    {
        $qb = $this->createQueryBuilder('user');
        foreach ($tokens as $key => $token) {
            $qb->orWhere('user.firstName like :firstName' . $key);
            $qb->orWhere('user.lastName like :lastName' . $key);
            $qb->setParameter('firstName' . $key, $token);
            $qb->setParameter('lastName' . $key, $token);
        }

        return $qb->getQuery()->getResult();
    }
}
