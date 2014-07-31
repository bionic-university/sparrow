<?php

namespace BionicUniversity\Bundle\UserBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findUsers($search_name, $search_lname, $search_gender, $search_dep, $search_email)
    {
         $repository = $this->getDoctrine()->getRepository('BionicUniversityUserBundle:User');

//        $sss = $repository->findOneByFirstName($search_name);

        /*$query = $repository->createQueryBuilder('p')
            ->where('p.price > :price')
            ->setParameter('price', '19.99')
            ->orderBy('p.price', 'ASC')
            ->getQuery();

        $search_result = $query->getResult();
        */

  //      return $sss;
    }
}