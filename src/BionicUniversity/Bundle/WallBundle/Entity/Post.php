<?php

namespace BionicUniversity\Bundle\WallBundle\Entity;
use BionicUniversity\Bundle\UserBundle\BionicUniversityUserBundle;
use BionicUniversity\Bundle\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Post
 */
class Post
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var User
     */
    private $author;

    /**
     * @var string
     */
    private $text;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var Wall
     */
    private $wall;

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
     * Get wall
     * @return Wall
     */
    public function getWall()
    {
        return $this->wall;
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