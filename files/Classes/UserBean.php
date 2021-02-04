<?php

class UserBean
{
    private $con;
    private $userData;

    public function __construct($con,$userName)
    {
        $this->con=$con;

        $query = $this->con->prepare("SELECT * FROM user_accounts where userName=:un");
        $query->bindParam(':un',$userName);
        $query->execute();

        $this->userData = $query->fetch(PDO::FETCH_ASSOC);
    }


    public function getFirstName()
    {
        return $this->userData["firstName"];
    }

    public function getLasttName()
    {
        return $this->userData["lastName"];
    }
    public function getEmail()
    {
        return $this->userData["email"];
    }
    public function getAccountCreatedOn()
    {
        return $this->userData["accountCreatedOn"];
    }
    public function getUserName()
    {
        return $this->userData["userName"];
    }
    
    
}


?>