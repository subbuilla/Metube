<?php

class CommentsClass
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


public function getAllCommentsOfVideo($videoId)
{
    try
    {
        $query=$this->con->prepare("select * from Comments where videoId=:vi order by commentOrder");
        $query->bindParam(":vi",$videoId);
        $query->execute();

        if($query->rowCount()==0)
        {
            return "";
        }
        else
        {
            $html="";
            while($row=$query->fetch(PDO::FETCH_ASSOC))
            {
                $comment=$row['comment'];
                $postedBy=$row['postedBy'];
                $comentedDate =$row['commentedDate'];
                $html.="<div style='margin-right:425px;' class='container1'><span class='text-success'>$postedBy</span><p>$comment</p>  <span class='time-right'>$comentedDate</span></div>";
            }
            //$html.="</div>";

  
          return $html;
        }


    }

    catch(Exception $e)
    {
        echo"Some Error Occured: ".$e->getMessage();
    }
}


public function postComment($postedBy,$videoId,$comment)

{
    try
    {
        $query=$this->con->prepare("select max(commentOrder) from Comments where videoId=:vi");
        $query->bindParam(":vi",$videoId);
        $query->execute();

        if($query->rowCount()==0)
        {
            $commentOrder = 1;
        }
        else
        {
            $value1 = $query->fetchColumn();
            $commentOrder = $value1+1;
        }
        

        $query1=$this->con->prepare("insert into Comments (postedBy,comment,videoId,commentOrder) values (:pb,:com,:vi,:co)");
        $query1->bindParam(":pb",$postedBy);
        $query1->bindParam(":com",$comment);
        $query1->bindParam(":vi",$videoId);
        $query1->bindParam(":co",$commentOrder);
        $query1->execute();

    }
    catch(Exception $e)
    {
        echo"Some Error Occured: ".$e->getMessage();
    }
    
}




}

?>