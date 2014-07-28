<?php
namespace BionicUniversity\Bundle\UserBundle\Entity;

use BionicUniversity\Bundle\UserBundle\Entity\User;

/**
 * Friendships
 */
class Friendship
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var User
     */
    private $userSender;

    /**
     * @var User
     */
    private $userReceiver;

    /**
     * @var integer
     */
    private $acceptanceStatus;

    /**
     * @param int $acceptanceStatus
     */
    public function setAcceptanceStatus($acceptanceStatus)
    {
        $this->acceptanceStatus = $acceptanceStatus;
    }

    /**
     * @return int
     */
    public function getAcceptanceStatus()
    {
        return $this->acceptanceStatus;
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
     * @param User $userSender
     */
    public function setUserSender(User $userSender)
    {
        $this->userSender = $userSender;
    }

    /**
     * @return mixed
     */
    public function getUserSender()
    {
        return $this->userSender;
    }

    /**
     * @param User $user
     */
    public function setUserReceiver(User $userReceiver)
    {
        $this->userReceiver = $userReceiver;
    }

    /**
     * @return mixed
     */
    public function getUserReceiver()
    {
        return $this->userReceiver;
    }

}