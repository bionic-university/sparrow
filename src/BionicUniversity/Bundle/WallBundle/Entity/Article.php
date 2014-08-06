<?php

namespace BionicUniversity\Bundle\WallBundle\Entity;
use Symfony\Component\Validator\Constraints\DateTime;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 */
class Article
{
    /**
     * @var integer
     * @Assert\Type(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     */
    private $createdAt;

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
}
