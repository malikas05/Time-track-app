<?php
class TaskClass
{
    private $id;
    private $description;
    private $start;
    private $end;
    private $userId;
    private $catId;
    private $projectId;
    private $taskToTagId;

    public function __construct($id, $description, $start, $end, $userId, $catId, $projectId, $taskToTagId)
    {
        $this->id = $id;
        $this->description = $description;
        $this->start = $start;
        $this->end = $end;
        $this->userId = $userId;
        $this->catId = $catId;
        $this->projectId = $projectId;
        $this->taskToTagId = $taskToTagId;
    }

    function getId(){
        return $this->id;
    }

    function getDescription(){
        return $this->description;
    }

    function getStart(){
        return $this->start;
    }

    function getEnd(){
        return $this->end;
    }


    function getUserId(){
        return $this->userId;
    }

    function getCatId(){
        return $this->catId;
    }

    function getProjectId(){
        return $this->projectId;
    }

    function getTaskToTagId(){
        return $this->taskToTagId;
    }
}
?>