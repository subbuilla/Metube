<?php

class ChannelClass
{
    private $con;
    private $errorMessages=array();

    public function __construct($con)
    {
        $this->con=$con;
    }

    public function getChannel($loggedInUserName)
    {
        try
        {
            $query=$this->con->prepare("select * from Channels where createdBy=:un");
            $query->bindParam(":un",$loggedInUserName);
            $query->execute();

            if($query->rowCount()==0)
            {
                return "";
            }
            else
            {
                $html="<div class='table-responsive'><table class='table table-bordered table-striped table-hover'>
                <thead class='thead-dark'>
                <tr>
                <th>Channel Name</th>
                <th>Edit Channel Name</th>
                </tr>
                </thead>
                <tbody>";
                while($row=$query->fetch(PDO::FETCH_ASSOC))
                {
                    $channelName=$row['channelName'];
                    $html.= "<td>$channelName</td>";
                    $html.="<td><form action='channels.php' method='POST'><button type='submit' class='btn btn-primary' name='channeledit'>Edit</button></form></td>";

                }
                $html.="</tbody>
                 </table> 
                 </div>";
                 return $html;
            }
        }

        catch(Exception $e)
        {
            echo"Some Error Occured: ".$e->getMessage();
        }
    }

    public function createChannel($createdBy,$channelName)
    {
        try
        {
            $this->validateChannelName($channelName);
            if(empty($this->errorMessages))
            {
                $query = $this->con->prepare("insert into Channels(channelName,createdBy) values(:cn,:cb)");
                $query->bindParam(":cn",$channelName);
                $query->bindParam(":cb",$createdBy);

               return $query->execute();

            }
            else
            {
                return false;
            }
        }
        catch(Exception $e)
        {
            echo"Some Error Occured: ".$e->getMessage();
        }

    }




public function updateChannelName($createdBy,$channelName)
{
    try
    {
    $this->validateChannelName($channelName);
    if(empty($this->errorMessages))
    {
        $query = $this->con->prepare("update Channels set channelName=:cn where createdBy=:cb");
        $query->bindParam(":cn",$channelName);
        $query->bindParam(":cb",$createdBy);

       return $query->execute();

    }
    else
    {
        return false;
    }
    }
    catch(Exception $e)
        {
            echo"Some Error Occured: ".$e->getMessage();
        }
}




    public function validateChannelName($channelName)
    {

        
        $query = $this->con->prepare("SELECT channelName from Channels where channelName=:cn");
        $query->bindParam(":cn",$channelName);
        $query->execute();
        if($query->rowCount()!= 0)
        {
            array_push($this->errorMessages,Properties::$channelUniqueError);
        }
    }





    public function displayError($error)
    {
        if(in_array($error,$this->errorMessages))
        {
            return "<span class='error text-center text-danger'>$error</span>";
        }
    }
}

?>