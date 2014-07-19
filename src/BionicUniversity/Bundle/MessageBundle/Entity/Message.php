<?php

namespace BionicUniversity\Bundle\MessageBundle\Entity;

/**
 * Message
 */
use BionicUniversity\Bundle\UserBundle\Entity\User;

/**
 * Class Message
 * @package BionicUniversity\Bundle\MessageBundle\Entity
 */
class Message
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var User
     */
    private $fromUser;

    /**
     * @var User
     */
    private $toUser;

    /**
     * @var string
     */
    private $body;


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
     * Set body
     *
     * @param  string $body
     * @return Message
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param \BionicUniversity\Bundle\UserBundle\Entity\User $fromUser
     */
    public function setFromUser($fromUser)
    {
        $this->fromUser = $fromUser;
    }

    /**
     * @return \BionicUniversity\Bundle\UserBundle\Entity\User
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * @param \BionicUniversity\Bundle\UserBundle\Entity\User $toUser
     */
    public function setToUser($toUser)
    {
        $this->toUser = $toUser;
    }

    /**
     * @return \BionicUniversity\Bundle\UserBundle\Entity\User
     */
    public function getToUser()
    {
        return $this->toUser;
    }


}