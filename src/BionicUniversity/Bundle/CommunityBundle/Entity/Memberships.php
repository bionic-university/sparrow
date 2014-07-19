<?php

namespace BionicUniversity\Bundle\CommunityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Memberships
 */
class Memberships
{
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
