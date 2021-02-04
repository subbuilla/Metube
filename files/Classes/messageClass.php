<?php

class MessageClass 
{
    private $con;
    
    public function __construct($con)
    {
        $this->con=$con;
    }

    public function getAllUserstoMessage($userName)
    {





        try
        {
            $query = $this->con->prepare("select * from user_accounts where userName<>:un");
            $query->bindParam(':un',$userName);
            $query->execute();

            if($query->rowCount()== 0)
            {
                // echo $userName;
                // echo"row count 0";
                return "";
            }
            else
            {

                
            
                $html = "
                <div><div class='table-responsive'><table class='table table-bordered table-striped table-hover'>
                        <thead class='thead-dark'>
                        <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Send Message</th>
                        </tr>
                    
                        </thead>
                        <tbody>";

                while($row=$query->fetch(PDO::FETCH_ASSOC))
                 {
                    $userName=$row["userName"];
                   // array_push($this->usersAray,$userName);
                    $name=$row["firstName"]." ".$row["lastName"];
                    $email=$row["email"];
                    $html.=  "<tr><td>$userName</td>";
                    $html.=  "<td>$name</td>";
                    $html.=  "<td>$email</td>";
                    
                    $html.=  "<td> <div style='padding-bottom:10px;' class='text-right'>
                    <form action='messageUser.php' method='POST'>
                    <button type='submit' class='btn btn-primary' name='messageButton' value='$userName'>Check Mailbox</button>
                    </form>
                    </div></td></tr>";
                    


                 }
                 $html.="</tbody>
                 </table></div>
                </div>";
                 return $html;
            }
        }
        catch(Exception $e)
        {
            echo"Some Error Occured: ".$e->getMessage();
        }
    }

public function sendMessage($sentBy,$sentTo,$message)

{
    try
    {
        $query1=$this->con->prepare("select max(messageOrder) as maxMessageOrder1 from Messages where sentBy=:sb and sentTo=:st");
        $query1->bindParam(":sb",$sentBy);
        $query1->bindParam(":st",$sentTo);
        $query1->execute();
        $value1 = $query1->fetchColumn();

        $query2=$this->con->prepare("select max(messageOrder) as maxMessageOrder2 from Messages where sentBy=:sbb and sentTo=:stt");
        $query2->bindParam(":stt",$sentBy);
        $query2->bindParam(":sbb",$sentTo);
        $query2->execute();
        $value2 = $query2->fetchColumn();
        if($query1->rowCount()==0 && $query2->rowCount()==0)
        {
            $messageOrder=1;
        }
        else if($value1>$value2)
        {
            $messageOrder=$value1+1;
        }
        else
        {
            $messageOrder=$value2+1;
        }
        $query3=$this->con->prepare("insert into Messages (sentBy,sentTo,message,messageOrder) values (:sb1,:st1,:me,:mo)");
        $query3->bindParam(":sb1",$sentBy);
        $query3->bindParam(":st1",$sentTo);
        $query3->bindParam(":me",$message);
        $query3->bindParam(":mo",$messageOrder);
        $query3->execute();

    }
    catch(Exception $e)
        {
            echo"Some Error Occured: ".$e->getMessage();
        }
}

public function getMessagesOfUsers($user1,$user2)

{
    try
    {
        $query1=$this->con->prepare("select * from (select * from Messages where sentBy=:sb and sentTo=:st union all select * from Messages where sentBy=:st and sentTo=:sb) dum order by messageOrder");
        $query1->bindParam(":sb",$user1);
        $query1->bindParam(":st",$user2);
        $query1->execute();

        if($query1->rowCount()==0)
        {
            return "";
        }
        else
        {
            $html="<div class='chatbox' ><div id='chatscroll' class='chat'>";

            while($row=$query1->fetch(PDO::FETCH_ASSOC))
            {
                $message=$row['message'];
                if($row["sentBy"]==$user1)
                {
                    $html.= "<div class='mine messages' style='padding-bottom:30px;'><div class='message last'>$message</div></div>";
                }
                else
                {
                    $html.= "<div class='yours messages' style='padding-bottom:30px;'><div class='message last'>$message</div></div>";
                }

            }
            $html.="</div></div> <script type='text/javascript'>
            myFunction('chatscroll');
         </script>";
            return $html;
        }


    }
    catch(Exception $e)
        {
            echo"Some Error Occured: ".$e->getMessage();
        }
}




    
}




?>