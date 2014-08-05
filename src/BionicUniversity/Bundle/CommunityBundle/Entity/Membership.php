<?php

namespace BionicUniversity\Bundle\CommunityBundle\Entity;

use BionicUniversity\Bundle\UserBundle\Entity\User;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Memberships
 */
class Membership
{
    /**
     * @var integer
     * @Assert\Type(type="integer")
     */
    private $id;

    /**
     * @var User
     * @Assert\NotBlank()
     */
    private $user;

    /**
     * @var Community
     * @Assert\NotBlank()
     */
    private $community;

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
     * @param Community $community
     */
    public function setCommunity(Community $community)
    {
        $this->community = $community;
    }

    /**
     * @return mixed
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

}
