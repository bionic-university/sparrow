<?php

namespace BionicUniversity\Bundle\CommunityBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @var string
     */
    private $description;

    /**
     * @return ArrayCollection
     */
    public function getMemberships()
    {
        return $this->memberships;
    }

    /**
     * @var ArrayCollection
     */
    private $memberships;


    private function __construct()
    {
        $this->memberships = new ArrayCollection();
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
}
