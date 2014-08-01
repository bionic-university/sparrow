<?php

namespace BionicUniversity\Bundle\UserBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findUsers($search_name, $search_lname, $search_gender, $search_dep, $search_email)
    {
         $repository = $this->getEntityManager()->getRepository('BionicUniversityUserBundle:User');

        $query = $repository->createQueryBuilder('user')
            ->where('user.firstName = :name and user.lastName = :lname and user.email = :email and user.gender = :gender and user.department = :dept ')
            ->setParameters(array ('name'=> $search_name, 'lname'=> $search_lname, 'email' => $search_email, 'dept' => $search_dep, 'gender' => $search_gender))
            ->getQuery();

        return $query->getSingleResult();
    }
}