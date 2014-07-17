<?php

namespace BionicUniversity\Bundle\WallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wall
 */
class Wall
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
