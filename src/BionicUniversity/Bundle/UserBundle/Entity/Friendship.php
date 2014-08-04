<?php

namespace BionicUniversity\Bundle\UserBundle\Entity;

/**
 * Friendships
 */
class Friendship
{
    const DECLINED = -1;
    const UNCONFIRMED = 0;
    const CONFIRMED = 1;
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

    public function __construct()
    {
        $this->acceptanceStatus = self::UNCONFIRMED;
    }

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
     * @param User $userReceiver
     */
    public function setUserReceiver($userReceiver)
    {
        $this->userReceiver = $userReceiver;
    }

    /**
     * @param User $userSender
     */
    public function setUserSender($userSender)
    {
        $this->userSender = $userSender;
    }

    /**
     * @return User
     */
    public function getUserReceiver()
    {
        return $this->userReceiver;
    }

    /**
     * @return User
     */
    public function getUserSender()
    {
        return $this->userSender;
    }
}
