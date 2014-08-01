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
    private $post;
    /**
     * @var Community
     */
    private $community;

    public function __construct()
    {
        $this->post = new ArrayCollection();
        $this->news = new ArrayCollection();
    }
    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return ArrayCollection
     */
    public function getPost()
    {
        return $this->post;
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
