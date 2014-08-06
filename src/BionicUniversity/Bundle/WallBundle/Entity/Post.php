<?php

namespace BionicUniversity\Bundle\WallBundle\Entity;
use BionicUniversity\Bundle\UserBundle\Entity\User;
use BionicUniversity\Bundle\CommunityBundle\Entity\Community;
use Symfony\Component\Validator\Constraints\DateTime;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Post
 */
class Post
{
    /**
     * @var integer
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @var User
     * @Assert\NotBlank()
     */
    private $author;

    /**
     * @var string
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @var Community
     * @Assert\NotBlank()
     */
    private $community;

    public function __construct()
    {
      $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     * @param  string $text
     * @return Post
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set createdAt
     * @param  \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get community
     * @return Community
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * Set community
     * @param  Community $community
     * @return Community
     */
    public function setCommunity(Community $community)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Set author
     * @param  User $author
     * @return User
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
