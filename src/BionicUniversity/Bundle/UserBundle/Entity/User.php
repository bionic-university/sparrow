<?php

namespace BionicUniversity\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    const GENDER_MALE = 'm';
    const GENDER_FEMALE = 'f';
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
    private $department;

    /**
     * @var string
     */
    private $gender;

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

    /**
     * @var ArrayCollection
     */
    private $friendshipsSender;

    /**
     * @var ArrayCollection
     */
    private $friendshipsReceiver;
    /**
     * @var \DateTime
     */
    private $dateOfBirth;

    public function __construct()
    {
        parent::__construct();
        $this->incomingMessages = new ArrayCollection();
        $this->outcomingMessages = new ArrayCollection();
        $this->memberships = new ArrayCollection();
        $this->friendshipsSender = new ArrayCollection();
        $this->friendshipsReceiver = new ArrayCollection();
        $this->groups = ['ROLE_USER'];
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
     * @param \Doctrine\Common\Collections\ArrayCollection $friendshipsSender
     */
    public function setFriendshipsSender($friendshipsSender)
    {
        $this->friendshipsSender = $friendshipsSender;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFriendshipsSender()
    {
        return $this->friendshipsSender;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $friendshipsReceiver
     */
    public function setFriendshipsReceiver($friendshipsReceiver)
    {
        $this->friendshipsReceiver = $friendshipsReceiver;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFriendshipsReceiver()
    {
        return $this->friendshipsReceiver;
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
     * Set department
     *
     * @param  string $department
     * @return User
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
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

    /**
     * Add incomingMessages
     *
     * @param  \BionicUniversity\Bundle\MessageBundle\Entity\Message $incomingMessages
     * @return User
     */
    public function addIncomingMessage(\BionicUniversity\Bundle\MessageBundle\Entity\Message $incomingMessages)
    {
        $this->incomingMessages[] = $incomingMessages;

        return $this;
    }

    /**
     * Remove incomingMessages
     *
     * @param \BionicUniversity\Bundle\MessageBundle\Entity\Message $incomingMessages
     */
    public function removeIncomingMessage(\BionicUniversity\Bundle\MessageBundle\Entity\Message $incomingMessages)
    {
        $this->incomingMessages->removeElement($incomingMessages);
    }

    /**
     * Add outcomingMessages
     *
     * @param  \BionicUniversity\Bundle\MessageBundle\Entity\Message $outcomingMessages
     * @return User
     */
    public function addOutcomingMessage(\BionicUniversity\Bundle\MessageBundle\Entity\Message $outcomingMessages)
    {
        $this->outcomingMessages[] = $outcomingMessages;

        return $this;
    }

    /**
     * Remove outcomingMessages
     *
     * @param \BionicUniversity\Bundle\MessageBundle\Entity\Message $outcomingMessages
     */
    public function removeOutcomingMessage(\BionicUniversity\Bundle\MessageBundle\Entity\Message $outcomingMessages)
    {
        $this->outcomingMessages->removeElement($outcomingMessages);
    }

    /**
     * Add memberships
     *
     * @param  \BionicUniversity\Bundle\UserBundle\Entity\User $memberships
     * @return User
     */
    public function addMembership(\BionicUniversity\Bundle\UserBundle\Entity\User $memberships)
    {
        $this->memberships[] = $memberships;

        return $this;
    }

    /**
     * Remove memberships
     *
     * @param \BionicUniversity\Bundle\UserBundle\Entity\User $memberships
     */
    public function removeMembership(\BionicUniversity\Bundle\UserBundle\Entity\User $memberships)
    {
        $this->memberships->removeElement($memberships);
    }

    /**
     * Set dateOfBirth
     *
     * @param  \DateTime $dateOfBirth
     * @return User
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }
}
