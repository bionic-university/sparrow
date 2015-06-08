<?php

namespace BionicUniversity\Bundle\CommunityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use BionicUniversity\Bundle\WallBundle\Entity\Post;
use BionicUniversity\Bundle\UserBundle\Entity\User;
use BionicUniversity\Bundle\CommunityBundle\Entity\ProjectTask;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Community
 */
class Community
{
    /**
     * @var integer
     * @Assert\Type(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(
     *      max = "50",
     *      maxMessage = "Community name cannot be longer than 50 characters length"
     *      )
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var ArrayCollection
     */
    private $posts;

    /**
     * @var ArrayCollection
     */
    private $projectTasks;

    /**
     * @var ArrayCollection
     */
    private $memberships;

    /**
     * @var User
     */
    private $owner;

    /**
     * @var string
     */
    private $avatar;

    public function __construct()
    {
        $this->createdAt = new \dateTime();
        $this->memberships = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->projectTasks = new ArrayCollection();
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
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param ProjectTask $projectTask
     */
    public function setProjectTasks($projectTask)
    {
        $this->projectTasks = $projectTask;
    }

    /**
     * @return ProjectTask
     */
    public function getProjectTasks()
    {
        return $this->projectTasks;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return (null !== $this->avatar) ? $this->avatar : 'no_avatar.jpg';
    }

    public function getFullAvatar()
    {
        return sprintf('/uploads/community_logo/%s', $this->getAvatar());
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

    /**
     * @param ProjectTask $projectTask
     * @return ProjectTask
     */
    public function addProjectTask(ProjectTask $projectTask)
    {
        $this->projectTasks[] = $projectTask;

        return $this;
    }

    /**
     * @param ProjectTask $projectTask
     */
    public function removeProjectTask(ProjectTask $projectTask)
    {
        $this->projectTasks->removeElement($projectTask);
    }
}
