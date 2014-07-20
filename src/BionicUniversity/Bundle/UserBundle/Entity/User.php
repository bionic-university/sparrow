<?php

namespace BionicUniversity\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $position;

    /**
     * @var string
     */
    private $sex;
    /**
     * @var ArrayCollection
     */
    private $incomingMessages;
    /**
     * @var ArrayCollection
     */
    private $outcomingMessages;
    /**
     * @var ArrayCollection
     */
    private $memberships;

    public function __construct()
    {
        $this->incomingMessages = new ArrayCollection();
        $this->outcomingMessages = new ArrayCollection();
        $this->memberships = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getMemberships()
    {
        return $this->memberships;
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
     * Set firstName
     *
     * @param  string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param  string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set position
     *
     * @param  string $position
     * @return User
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set sex
     *
     * @param  string $sex
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getIncomingMessages()
    {
        return $this->incomingMessages;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOutcomingMessages()
    {
        return $this->outcomingMessages;
    }


}
