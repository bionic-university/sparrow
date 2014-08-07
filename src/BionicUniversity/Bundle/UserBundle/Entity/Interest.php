<?php

namespace BionicUniversity\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 */

use Symfony\Component\Validator\Constraints as Assert;

class Interest
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
     *      max = "255000",
     *      )
     */
    private $logo;

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

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
     * Set name
     *
     * @param  string   $name
     * @return Interest
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
     * Add users
     *
     * @param  \BionicUniversity\Bundle\UserBundle\Entity\User $users
     * @return Interest
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
}
