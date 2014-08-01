<?php

namespace BionicUniversity\Bundle\UserBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findUsers($search_name, $search_lname, $search_gender, $search_dep, $search_email)
    {
         $repository = $this->getEntityManager()->getRepository('BionicUniversityUserBundle:User');

        $query = $repository->createQueryBuilder('user')
            ->where('user.firstName = :name')
            ->setParameter('name', $search_name)
            ->getQuery();

        return $query->getSingleResult();
    }
}