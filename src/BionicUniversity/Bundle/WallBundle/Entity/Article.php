<?php

namespace BionicUniversity\Bundle\WallBundle\Entity;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Article
 */
class Article
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $title;
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
     * Set title
     * @param  string  $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
    /**
     * Get title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Set text
     * @param  string  $text
     * @return Article
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
     * @return Article
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

    public function getWall()
    {
        return $this->wall;
    }
}
