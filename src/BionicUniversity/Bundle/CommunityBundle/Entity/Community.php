<?php

namespace BionicUniversity\Bundle\CommunityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use BionicUniversity\Bundle\WallBundle\Entity\Post;
use BionicUniversity\Bundle\UserBundle\Entity\User;

/**
 * Community
 */
class Community
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $description;

    /**
     * @var ArrayCollection
     */
    private $posts;

    /**
     * @var ArrayCollection
     */
    private $memberships;

    /**
     * @var User
     */
    private $owner;

    public function __construct()
    {
        $this->createdAt = new \dateTime();
        $this->memberships = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return ArrayCollection
     */
    public function getMemberships()
    {
        return $this->memberships;
    }

    /**
     * @return \BionicUniversity\Bundle\UserBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param \BionicUniversity\Bundle\UserBundle\Entity\User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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
     * @param  string $name
     * @return Community
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
     * Set description
     *
     * @param  string $description
     * @return Community
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add memberships
     *
     * @param  \BionicUniversity\Bundle\CommunityBundle\Entity\Community $memberships
     * @return Community
     */
    public function addMembership(\BionicUniversity\Bundle\CommunityBundle\Entity\Community $memberships)
    {
        $this->memberships[] = $memberships;

        return $this;
    }

    /**
     * Remove memberships
     *
     * @param \BionicUniversity\Bundle\CommunityBundle\Entity\Community $memberships
     */
    public function removeMembership(\BionicUniversity\Bundle\CommunityBundle\Entity\Community $memberships)
    {
        $this->memberships->removeElement($memberships);
    }

    /**
     * Add posts
     *
     * @param  \BionicUniversity\Bundle\WallBundle\Entity\Post $posts
     * @return Post
     */
    public function addPost(Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove memberships
     *
     * @param \BionicUniversity\Bundle\WallBundle\Entity\Post $posts
     */
    public function removePost(Post $post)
    {
        $this->posts->removeElement($post);
    }
}
