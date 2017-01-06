<?php
class ProjectClass
{
    private $id;
    private $title;
    private $colour;

    public function __construct($id, $title, $colour)
    {
        $this->id = $id;
        $this->title = $title;
        $this->colour = $colour;
    }

    function getId(){
        return $this->id;
    }

    function getTitle(){
        return $this->title;
    }

    function getColour(){
        return $this->colour;
    }
}
?>