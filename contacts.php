<?php require_once("commonFiles/header.php"); 
      require_once("files/Classes/contactList.php");
      require_once("files/Classes/Properties.php");
      require_once("files/Classes/ContactBean.php");

?>


<div class='container' style='padding-top:10px;'>
<div class='jumbotron'>
    <h2 class="text-dark display-3 text-center">Contacts</h2>

    <?php
    //$contactBean = new ContactBean();
    $contactList = new ContactList($con);
    $result= $contactList->getContacts($loggedInUserName);

    if($result!="")
    {
        echo $result;
    }
    else
    {
       echo" <div style='padding-bottom:10px;' class='text-center'>
        <form action='addContacts.php' method='POST'>
        <button type='submit' class='btn btn-success' name='add'>Add New Contacts</button>
        </form>
        </div>";


        echo "<h5 class='text-primary display-5 text-center'>";
        echo Properties::$NoContacts;
        "</h5>";
    }
                if(isset($_POST['blockUpdate']))
                {
                    $arrayex=array();


                    if(isset($_POST['blocktoggle']))
                    {
                    $arrayex=$_POST['blocktoggle'];
                    }
                    else
                    {
                   // $arrayex = array(uniqid()."empty");
                    }
                    foreach($arrayex as $selected) {
                        echo "<p>".$selected ."</p>";
                        }
                    $contactList->blockContact($loggedInUserName,$arrayex);
                    header("location:contacts.php");
                }
    ?>


</div>
</div>

<?php require_once("commonFiles/footer.php")?>