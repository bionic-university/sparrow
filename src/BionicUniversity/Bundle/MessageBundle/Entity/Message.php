<?php

namespace BionicUniversity\Bundle\MessageBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Message
 * @package BionicUniversity\Bundle\MessageBundle\Entity
 */
class Message
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
    private $fromUser;

    /**
     * @var User
     * @Assert\NotBlank()
     */
    private $toUser;

    /**
     * @var string
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     */
    private $body;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @var integer
     */
    private $isread;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
     * Set body
     *
     * @param  string  $body
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

    public function getIsRead()
    {
        return $this->isread;
    }

    public function setIsRead($x)
    {
        $this->isread = $x;
    }
}
