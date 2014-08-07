<?php

namespace BionicUniversity\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 */

use Symfony\Component\Validator\Constraints as Assert;

class Event
{
    /**
     * @var integer
     * @Assert\Type(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      max = "50",
     *      )
     * @Assert\NotBlank()
     */
    private $name;
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $description;
    /**
     * @var ArrayCollection
     */
    private $users;

    public function __construct()
    {
        $this->date = new \DateTime();
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
     * @param string $name
     * @return Event
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
     * Set date
     *
     * @param \DateTime $date
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add users
     *
     * @param \BionicUniversity\Bundle\UserBundle\Entity\User $users
     * @return Event
     */
    public function addUser(\BionicUniversity\Bundle\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \BionicUniversity\Bundle\UserBundle\Entity\User $users
     */
    public function removeUser(\BionicUniversity\Bundle\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

}
