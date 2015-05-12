<?php

namespace BionicUniversity\Bundle\CommunityBundle\Entity;

use BionicUniversity\Bundle\CommunityBundle\Entity\TaskManager;
use BionicUniversity\Bundle\CommunityBundle\Entity\Community;

/**
 * ProjectTask
 */
class ProjectTask
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
    private $description;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var TaskManager
     */
    private $taskManager;

    /**
     * @var Community
     */
    private $community;

    function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->taskManager = null;
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
     * Set title
     *
     * @param string $title
     *
     * @return ProjectTask
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ProjectTask
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ProjectTask
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return TaskManager
     */
    public function getTaskManager()
    {
        return $this->taskManager;
    }

    /**
     * @param TaskManager $taskManager
     */
    public function setTaskManager(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    /**
     * @return Community
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * @param Community $community
     */
    public function setCommunity(Community $community)
    {
        $this->community = $community;
    }



}

