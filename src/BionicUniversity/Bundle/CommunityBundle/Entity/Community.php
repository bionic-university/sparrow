<?php

namespace BionicUniversity\Bundle\CommunityBundle\Entity;

use BionicUniversity\Bundle\WallBundle\Entity\Wall;

/**
 * Community
 */
class Community
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;
    /**
     * @var \dateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $description;

    /**
     * @var ArrayCollection
     */
    private $wall;

    /**
     * @var Membership
     */
    private $memberships;

    /**
     * @var User
     */
    private $owner;

    public function __construct()
    {
        $this->createdAt = new \dateTime();
        $this->memberships = new ArrayCollection();
    }

    /**
     * @return \dateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getMemberships()
    {
        return $this->memberships;
    }

    /**
     * @return \BionicUniversity\Bundle\WallBundle\Entity\Wall
     */
    public function getWall()
    {
        return $this->wall;
    }

    /**
     * @param \BionicUniversity\Bundle\WallBundle\Entity\Wall $wall
     */
    public function setWall(Wall $wall)
    {
        $this->wall = $wall;
    }

    /**
     * @return \BionicUniversity\Bundle\UserBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param \BionicUniversity\Bundle\UserBundle\Entity\User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param \dateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param string $memberships
     */
    public function setMemberships($memberships)
    {
        $this->memberships = $memberships;
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
     * Set name
     *
     * @param  string $name
     * @return Community
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param  string $description
     * @return Community
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
