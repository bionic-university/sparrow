<?php

namespace BionicUniversity\Bundle\MessageBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class MessageRepository extends EntityRepository
{
    public function findMessages($firstUser, $secondUser)
    {
        $query = $this->createQueryBuilder('message')
            ->leftJoin('message.fromUser', 'f')
            ->leftJoin('message.toUser', 't')
            ->orWhere('f =:firstUser AND t = :secondUser')
            ->orWhere('f =:secondUser AND t = :firstUser')
            ->setParameters(['firstUser' => $firstUser, 'secondUser' => $secondUser])
            ->orderBy('message.createdAt')
            ->getQuery();

        return $query->getResult();
    }

    public function  findCountMessages($user)
    {
        $query = $this->createQueryBuilder('count(message)')
            ->where('message.toUser =:user')
            ->setParameter('user', $user)
            ->getQuery();

        return $query->getSingleResult();
    }

}
