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
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Wall
     */
    private $wall;

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
     * @param  string    $name
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
     * @param  string    $description
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

    public function setWall($wall)
    {
        $this->wall = $wall;
        return $this;
    }

    public function getWall()
    {
        return $this->wall;
    }
}
