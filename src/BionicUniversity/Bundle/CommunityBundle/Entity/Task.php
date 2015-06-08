<?php

namespace BionicUniversity\Bundle\CommunityBundle\Entity;

/**
 * Task
 */
class Task
{
    const STATUS_BACKLOG = 'backlog';
    const STATUS_READY = 'ready';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var TaskManager
     */
    private $taskManager;

    /**
     * @var string
     * @Assert\Choice(
     *      choices = { "backlog", "ready", "in_progress", "done" },
     *      message = "Choose a valid status."
     *      )
     * @Assert\NotBlank()
     */
    private $status;

    static private $statusValues;

    function __construct()
    {
        $this->$statusValues = null;
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
     * @return Task
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Task
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
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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



    static public function getMyEnumFieldChoices()
    {
        // Build $_myEnumFieldValues if this is the first call
        if (self::$statusValues == null)
        {
            self::$statusValues = array ();
            $oClass = new \ReflectionClass('Bi');
            $classConstants = $oClass->getConstants('BionicUniversity\Bundle\CommunityBundle\Entity\Task');
            $constantPrefix = "STATUS_";
            foreach ($classConstants as $key => $val)
            {
                if (substr($key, 0, strlen($constantPrefix)) === $constantPrefix)
                {
                    self::$statusValues[$val] = $val;
                }
            }
        }
        return self::$statusValues;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setMyEnumField($status)
    {
        if (!in_array($status, self::getMyEnumFieldChoices()))
        {
            throw new \InvalidArgumentException(
                sprintf('Invalid value for Task.status : %s.', $status)
            );
        }

        $this->status = $status;
    }

}

