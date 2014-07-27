<?php

namespace BionicUniversity\Bundle\UserBundle\Entity;
/**
 * Created by PhpStorm.
 * User: meraxes
 * Date: 27.07.14
 * Time: 14:27
 */

Class Search {
    protected $task;

    protected $dueDate;

    public function getTask()
    {
        return $this->task;
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
    }
}