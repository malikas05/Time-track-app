<?php
class User{
    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct($id, $name, $email, $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    function getId(){
        return $this->id;
    }

    function getName(){
        return $this->name;
    }

    function getEmail(){
        return $this->email;
    }

    function getPassword(){
        return $this->password;
    }
}
?>