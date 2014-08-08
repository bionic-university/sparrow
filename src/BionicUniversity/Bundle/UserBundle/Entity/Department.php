<?php

namespace BionicUniversity\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;


use Symfony\Component\Validator\Constraints as Assert;

class Department
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
     * @var string
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      max = "255",
     *      )
     */
    private $imageUrl;

    /**
     * @var ArrayCollection
     * @Assert\NotBlank()
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set name
     *
     * @param  string   $name
     * @return Department
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
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * Add users
     *
     * @param  \BionicUniversity\Bundle\UserBundle\Entity\User $users
     * @return Department
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

    public function __toString()
    {
        return $this->name;
    }
}
