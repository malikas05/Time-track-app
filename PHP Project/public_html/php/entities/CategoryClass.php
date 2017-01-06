<?php
class Category
{
    private $id;
    private $title;
    private $projectID;

    public function __construct($id, $title, $projectID)
    {
        $this->id = $id;
        $this->title = $title;
        $this->projectID = $projectID;
    }

    function getId(){
        return $this->id;
    }

    function getTitle(){
        return $this->title;
    }

    function getProjectId(){
        return $this->projectID;
    }
}
?>