<?php

namespace BionicUniversity\Bundle\WallBundle\Entity;

use BionicUniversity\Bundle\CommunityBundle\Entity\Community;
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
    /**
     * @var Community
     */
    private $community;

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

    public function setCommunity($community)
    {
        $this->community= $community;
    }
    public function getCommunity()
    {
        return $this->community;
    }
}
