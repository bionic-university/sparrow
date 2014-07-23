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
     * @var ArrayCollection
     */
    private $news;

    /**
     * @var Community
     */
    private $community;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->news = new ArrayCollection();
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

    /**
     * @return ArrayCollection
     */
    public function getNews()
    {
        return $this->news;
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
