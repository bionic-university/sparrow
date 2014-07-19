<?php

namespace BionicUniversity\Bundle\WallBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @var ArrayCollection
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
