<?php

class Video
{
    private $con;
    private $userData;
    //private $userloggedInObj;

    public function __construct($con,$input)
    {
        $this->con=$con;
        //$this->userloggedInObj=$userloggedInObj;

        if(is_array($input)){
            $this->userData=$input;

        }
        else{
            $query = $this->con->prepare("SELECT * FROM Videos where Id=:Id");
            $query->bindParam(':Id',$input);
            $query->execute();

            $this->userData = $query->fetch(PDO::FETCH_ASSOC);
        }

    }

    public function getId()
    {
        return $this->userData["Id"];
    }
    
    public function getUploadedBy()
    {
        return $this->userData["UploadedBy"];
    }

    public function getTitle()
    {
        return $this->userData["Title"];
    }

    public function getDescription()
    {
        return $this->userData["Description"];
    }

    public function getPrivacy()
    {
        return $this->userData["Privacy"];
    }

    public function getKeywords()
    {
        return $this->userData["Keywords"];
    }

    public function getFilepath()
    {
        return $this->userData["Filepath"];
    }

    public function getCategory()
    {
        return $this->userData["Category"];
    }

    public function getUploadDate()
    {
        $date=$this->userData["UploadDate"];
        return $date;
    }

    public function getTimestamp()
    {
        $date=$this->userData["UploadDate"];
        return date("M jS, Y", strtotime($date));
    }

    public function getViews()
    {
        return $this->userData["Views"];
    }


    public function getDuration()
    {
        return $this->userData["Duration"];
    }


    public function incrementViews(){
        $query= $this->con->prepare("UPDATE Videos SET Views=Views+1 WHERE Id=:Id");
        $query->bindParam(":Id", $videoId);

        $videoId=$this->getId();
        $query->execute();

        $this->userData["Views"]= $this->userData["Views"] + 1;
    }

    // public function getThumbnails(){
    //             $query= $this->con->prepare("SELECT Filepath FROM Thumbnails WHERE VideoId=:videoId AND Selected=1");
    //             $query->bindParam(":videoId", $videoId);
    //             $videoId= $this->getId();
    //             $query->execute(); 

    //             return $query->fetchColumn();
    // }



    // public function getDetails(){
    //     $query= $this->con->prepare("SELECT Filepath FROM Videos WHERE videoId=:Id");
    //     $query->bindParam(":Id", $videoId);
    //     $videoId= $this->getId();
    //     $query->execute(); 

         
    // }

    
}


?>