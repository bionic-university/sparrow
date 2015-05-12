<?php

namespace BionicUniversity\Bundle\CommunityBundle\Entity;

/**
 * TaskManager
 */
class TaskManager
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var array
     */
    private $tasks;

    /**
     * @var string
     */
    private $details;

    /**
     * @var ProjectTask
     */
    private $projectTask;

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
     * Set tasks
     *
     * @param array $tasks
     *
     * @return TaskManager
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * Get tasks
     *
     * @return array
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @return ProjectTask
     */
    public function getProjectTask()
    {
        return $this->projectTask;
    }

    /**
     * @param ProjectTask $projectTask
     */
    public function setProjectTask(ProjectTask $projectTask)
    {
        $this->projectTask = $projectTask;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

}

