<?php

      require_once("commonFiles/header.php"); 
      require_once("files/Classes/contactList.php");
      require_once("files/Classes/Properties.php");
      require_once("files/Classes/ContactBean.php");
?>

    <div class='container' style='padding-top:10px;'>
    <div class='jumbotron'>
    <h2 class="text-dark display-3 text-center">Add Contacts</h2>

    <?php
    
    $contactList = new ContactList($con);
    $result= $contactList->getAllUsers($loggedInUserName);

    if($result!="")
    {
        echo $result;
    }
    else
    {
        echo "<h5 class='text-primary display-5 text-center'>";
        echo Properties::$NoOtherUsers;
        "</h5>";
    }
                if(isset($_POST['addUpdate']))
                {
                    $arrayex1=array();
                    $arrayex2=array();


                    if(isset($_POST['addtoggle']))
                    {
                    $arrayex1=$_POST['addtoggle'];
                    //$arrayex2=$_POST['type'];
                    }
                    else
                    {
                   // $arrayex1 = array("empty");
                    }


                    foreach($arrayex1 as $selected) {
                      //  if($selected != "empty")
                        $contactBean = new ContactBean($selected,$_POST[$selected]);
                        array_push($arrayex2,$contactBean);

                        echo "<p>".$_POST[$selected]."</p>";
                        }

                    $contactList->addContact($loggedInUserName,$arrayex2);
                    header("location:addContacts.php");
                    //echo $_GET['blocktoggle'];
                }
    ?>
<div class='text-center' style='padding-top:20px;'><form action='contacts.php'><button type='submit' class='btn btn-warning'>Go Back</button></form></div>

</div>
</div>

<?php require_once("commonFiles/footer.php")?>



