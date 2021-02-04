<?php

require_once("files/Classes/ContactBean.php");

class ContactList 
{
private $con;
private $contactBean;
private $contactData=array();

    public function __construct($con)
    {
        $this->con=$con;
    }


    public function getContacts($userName)
    {
        try
        {
            $query = $this->con->prepare("select * from Contact_List inner Join user_accounts on Contact_List.contactUserName=user_accounts.userName where Contact_List.userName=:un");
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
                $contacts=$query->fetchAll(PDO::FETCH_ASSOC);
                $result = "<div style='padding-bottom:10px;' class='text-right'>
                <form action='addContacts.php' method='POST'>
                <button type='submit' class='btn btn-warning' name='add'>Add New Contacts</button>
                </form>
                </div>
                <div><form action='contacts.php' method='POST'>";

                

                $html="<h3 class='display-6'>Friends</h3>
                <div >
                <table class='table table-bordered table-striped table-hover'>
                        <thead class='thead-dark'>
                        <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Type</th>
                        <th>Block/UnBlock</th>
                        </tr>
                    
                        </thead>
                        <tbody>";



                foreach($contacts as $row)
                 {
                     
                    $contactUserName=$row["contactUserName"];
                    $contactName=$row["firstName"]." ".$row["lastName"];
                    $contactEmail=$row["email"];
                    $contactStatus=$row["status"];
                    $contactType=$row["contactType"];
                    if($contactType=='Friend')
                    {
                    $html.=  "<tr><td>$contactUserName</td>";
                    $html.=  "<td>$contactName</td>";
                    $html.=  "<td>$contactEmail</td>";
                    $html.=  "<td>$contactType</td>";
                    
                    if($contactStatus!='Not Blocked')
                    {
                    $html.=  "<td align='right'> <div class='form-check form-check-inline'>
                    <input id='$contactUserName' class='form-check-input' name='blocktoggle[]' value='$contactUserName' type='checkbox' data-toggle='toggle' data-style='mr-1' data-on='Blocked' data-off='Unblocked'data-onstyle='danger' data-offstyle='primary' data-size='small' checked>
                  </div></td></tr>";
                    }
                    else
                    {
                        $html.=  "<td align='right'> <div class='form-check form-check-inline'>
                        <input id='$contactUserName' class='form-check-input' name='blocktoggle[]' value='$contactUserName' type='checkbox' data-toggle='toggle' data-style='mr-1' data-on='Blocked' data-off='Unblocked'data-onstyle='danger' data-offstyle='primary' data-size='small' >
                      </div></td></tr>";
                    }
                }

                 }
                 $html.="</tbody>
                 </table></div>";









                 $html1=" <h3 class='display-6'>Family</h3>
                <div class='table-responsive'>
                <table class='table table-bordered table-striped table-hover'>
                        <thead class='thead-dark'>
                        <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Type</th>
                        <th>Block/UnBlock</th>
                        </tr>
                    
                        </thead>
                        <tbody>";
                foreach($contacts as $row)
                 {
                    $contactUserName=$row["contactUserName"];
                    $contactName=$row["firstName"]." ".$row["lastName"];
                    $contactEmail=$row["email"];
                    $contactStatus=$row["status"];
                    $contactType=$row["contactType"];
                    if($contactType=='Family')
                    {
                        
                    $html1.=  "<tr><td>$contactUserName</td>";
                    $html1.=  "<td>$contactName</td>";
                    $html1.=  "<td>$contactEmail</td>";
                    $html1.=  "<td>$contactType</td>";
                    
                    if($contactStatus!='Not Blocked')
                    {
                    $html1.=  "<td align='right'> <div class='form-check form-check-inline'>
                    <input id='$contactUserName' class='form-check-input' name='blocktoggle[]' value='$contactUserName' type='checkbox' data-toggle='toggle' data-style='mr-1' data-on='Blocked' data-off='Unblocked'data-onstyle='danger' data-offstyle='primary' data-size='small' checked>
                  </div></td></tr>";
                    }
                    else
                    {
                        $html1.=  "<td align='right'> <div class='form-check form-check-inline'>
                        <input id='$contactUserName' class='form-check-input' name='blocktoggle[]' value='$contactUserName' type='checkbox' data-toggle='toggle' data-style='mr-1' data-on='Blocked' data-off='Unblocked'data-onstyle='danger' data-offstyle='primary' data-size='small' >
                      </div></td></tr>";
                    }
                }

                 }
                 $html1.="</tbody>
                 </table></div>";




                 $html2=" <h3 class='display-6'>Favorites</h3>
                <div class='table-responsive'>
                <table class='table table-bordered table-striped table-hover'>
                        <thead class='thead-dark'>
                        <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Type</th>
                        <th>Block/UnBlock</th>
                        </tr>
                    
                        </thead>
                        <tbody>";

                foreach($contacts as $row)
                 {
                    $contactUserName=$row["contactUserName"];
                    $contactName=$row["firstName"]." ".$row["lastName"];
                    $contactEmail=$row["email"];
                    $contactStatus=$row["status"];
                    $contactType=$row["contactType"];
                    if($contactType=='Favorite')
                    {
                    $html2.=  "<tr><td>$contactUserName</td>";
                    $html2.=  "<td>$contactName</td>";
                    $html2.=  "<td>$contactEmail</td>";
                    $html2.=  "<td>$contactType</td>";
                    
                    if($contactStatus!='Not Blocked')
                    {
                    $html2.=  "<td align='right'> <div class='form-check form-check-inline'>
                    <input id='$contactUserName' class='form-check-input' name='blocktoggle[]' value='$contactUserName' type='checkbox' data-toggle='toggle' data-style='mr-1' data-on='Blocked' data-off='Unblocked'data-onstyle='danger' data-offstyle='primary' data-size='small' checked>
                  </div></td></tr>";
                    }
                    else
                    {
                        $html2.=  "<td align='right'> <div class='form-check form-check-inline'>
                        <input id='$contactUserName' class='form-check-input' name='blocktoggle[]' value='$contactUserName' type='checkbox' data-toggle='toggle' data-style='mr-1' data-on='Blocked' data-off='Unblocked'data-onstyle='danger' data-offstyle='primary' data-size='small' >
                      </div></td></tr>";
                    }
                }

                 }
                 $html2.="</tbody>
                 </table></div>";


                 $html3="     <h3 class='display-6'>Colleagues</h3>
                <div class='table-responsive'>
                <table class='table table-bordered table-striped table-hover'>
                        <thead class='thead-dark'>
                        <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Type</th>
                        <th>Block/UnBlock</th>
                        </tr>
                    
                        </thead>
                        <tbody>";

                foreach($contacts as $row)
                 {
                    $contactUserName=$row["contactUserName"];
                    $contactName=$row["firstName"]." ".$row["lastName"];
                    $contactEmail=$row["email"];
                    $contactStatus=$row["status"];
                    $contactType=$row["contactType"];
                    if($contactType=='Colleague')
                    {
                    $html3.=  "<tr><td>$contactUserName</td>";
                    $html3.=  "<td>$contactName</td>";
                    $html3.=  "<td>$contactEmail</td>";
                    $html3.=  "<td>$contactType</td>";
                    
                    if($contactStatus!='Not Blocked')
                    {
                    $html3.=  "<td align='right'> <div class='form-check form-check-inline'>
                    <input id='$contactUserName' class='form-check-input' name='blocktoggle[]' value='$contactUserName' type='checkbox' data-toggle='toggle' data-style='mr-1' data-on='Blocked' data-off='Unblocked'data-onstyle='danger' data-offstyle='primary' data-size='small' checked>
                  </div></td></tr>";
                    }
                    else
                    {
                        $html3.=  "<td align='right'> <div class='form-check form-check-inline'>
                        <input id='$contactUserName' class='form-check-input' name='blocktoggle[]' value='$contactUserName' type='checkbox' data-toggle='toggle' data-style='mr-1' data-on='Blocked' data-off='Unblocked'data-onstyle='danger' data-offstyle='primary' data-size='small' >
                      </div></td></tr>";
                    }
                }

                 }
                 $html3.="</tbody>
                 </table></div>";





                 $result.=$html;
                 $result.=$html1;
                 $result.=$html2;
                 $result.=$html3;

                 $result.=  "<div class='text-center'>
                 <button type='submit' class='btn btn-success' name='blockUpdate'>Update</button>
                 </div>
                 </form>
                 </div>";
                 return $result;
            }
        }
        catch(Exception $e)
        {
            echo"Some Error Occured: ".$e->getMessage();
        }
    }

    public function addContact($userName,$contactUsers)
    {



        foreach($contactUsers as $selected) {
            
            
        $query = $this->con->prepare("INSERT INTO Contact_List(userName,contactUserName,contactType) VALUES(:un,:cun,:ty)");
        $query->bindParam(":un",$userName);
        $query->bindParam(":cun",$selected->contactUserName);
        $query->bindParam(":ty",$selected->type);
        $query->execute();

        }

    }




    public function blockContact($userName,$contactUserNames)
    {
        $query = $this->con->prepare("select * from Contact_List where userName=:un");
        $query->bindParam(":un",$userName);
        $query->execute();

       while($row = $query->fetch(PDO::FETCH_ASSOC))
       {
           $contactUserName = $row["contactUserName"];

           if(in_array($contactUserName,$contactUserNames))
           {
            $status="Blocked";
            $query1 = $this->con->prepare("UPDATE Contact_List SET status=:st where userName=:un and contactUserName=:cun");
            $query1->bindParam(":un",$userName);

            $query1->bindParam(":st",$status);
            $query1->bindParam(":cun",$contactUserName);
            $query1->execute();
           }
           else
           {
            $status="Not Blocked";
            $query2 = $this->con->prepare("update Contact_List set status=:st where userName=:un and contactUserName=:cun");
            $query2->bindParam(":un",$userName);
            $query2->bindParam(":st",$status);
            $query2->bindParam(":cun",$contactUserName);
            $query2->execute();
           }
       }
    }

    public function getAllUsers($loggedInUserName)

    {
        try
        {
            $flag=0;
            $html="<div><form action='addContacts.php' method='POST'><div class='table-responsive'><table class='table table-bordered table-striped table-hover'>
            <thead class='thead-dark'>
            <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact Type</th>
            <th>Add User</th>
            </tr>
        
            </thead>
            <tbody>";
            $query = $this->con->prepare("select * from user_accounts where userName<>:un");
            $query->bindParam(':un',$loggedInUserName);
            $query->execute();


            if($query->rowCount()== 0)
            {
                echo $loggedInUserName;
                echo"row count 0";
                return "";
            }
else{
            $query1 = $this->con->prepare("select * from Contact_List where userName=:un");
            $query1->bindParam(':un',$loggedInUserName);
            $query1->execute();

            $addedUsers=array();
            while($row=$query1->fetch(PDO::FETCH_ASSOC))
            {
               $existingUserName=$row["contactUserName"];
                array_push($addedUsers,$existingUserName);
            }




            while($row=$query->fetch(PDO::FETCH_ASSOC))
            {
                $userName=$row["userName"];

                if(!in_array($userName,$addedUsers))
                {
                    $flag=1;
                    $name=$row["firstName"]." ".$row["lastName"];
                    $email=$row["email"];
                    $html.=  "<tr><td>$userName</td>";
                    $html.=  "<td>$name</td>";
                    $html.=  "<td>$email</td>";

                    $html.=  "<td> <div>
                    <select class='form-control' id='privacy' name='$userName' >
                     <option value='Friend'>Friend</option>
                     <option value='Family'>Family</option>
                    <option value='Favorite'>Favorite</option>
                    <option value='Colleague'>Colleague</option>
                     </select>
                    </div></td>";
                    $html.=  "<td> <div class='form-check form-check-inline'>
                    <input id='$userName' class='form-check-input' name='addtoggle[]' value='$userName' type='checkbox' data-toggle='toggle' data-style='mr-1' data-on='Add' data-off='No'data-onstyle='primary' data-offstyle='secondary' data-size='small'>
                  </div></td></tr>";

                    
                }    

            }

            if($flag == 0)
            {
                return "";
            }

            $html.="</tbody>
                 </table></div>
                 <div class='text-center'>
                 <button type='submit' class='btn btn-success' name='addUpdate'>Add</button>
                 </div>
                 </form>
                 </div>";
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
