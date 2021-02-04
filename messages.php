<?php require_once("commonFiles/header.php"); 
      require_once("files/Classes/messageClass.php");
      require_once("files/Classes/Properties.php");

?>




<div class='container' style='padding-top:10px;'>
<div class='jumbotron'>
    <h2 class="text-dark display-3 text-center">Mailbox</h2>

    <?php
    //$contactBean = new ContactBean();
    $messageClass = new MessageClass($con);
    $result= $messageClass->getAllUserstoMessage($loggedInUserName);

    if($result!="")
    {
        echo $result;
    }
    else
    {
    
        echo "<h5 class='text-primary display-5 text-center'>";
        echo Properties::$NoContacts;
        "</h5>";
    }
                
    ?>


</div>
</div>



<?php require_once("commonFiles/footer.php")?>