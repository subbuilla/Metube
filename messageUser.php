<?php require_once("commonFiles/header.php"); 
      require_once("files/Classes/messageClass.php");
      require_once("files/Classes/Properties.php");
      require_once("files/Classes/messageBean.php");

      $sentTo="";
      $sentBy=$loggedInUserName;
      $messageClass = new messageClass($con);
?>






    <?php




//$messageBean = new MessageBean($sentBy,$sentTo);
if(isset($_POST['messageButton']))
{
    $sentTo=$_POST['messageButton'];
    $result=$messageClass->getMessagesOfUsers($sentBy,$sentTo);

    if($result!="")
    {
        echo"<div style='padding-top:10px;'></div>";
        echo $result;
    }
    else{
        echo "No Messages";
    }

 //   $messageBean->$sentTo=$sentTo;
}

if(isset($_POST["sendMessage"]))
{

    $message=$_POST["message"];
    $sentTo=$_POST["sendMessage"];
    $messageClass->sendMessage($sentBy,$sentTo,$message);

    $result=$messageClass->getMessagesOfUsers($sentBy,$sentTo);


    if($result!="")
    {
        echo $result;
    }
    else{
        echo "No Messages";
    }
    //header("messageUser.php");

}
?>
<div  style='padding-top:10px;' >

<h2 class="display-6 text-left text-primary">Message To: <?php echo $sentTo; ?></h2>
    <form action="messageUser.php" method="POST" style="padding-top:20px">
    <div class="input-group">
    <input type="text" id="message" name="message" required placeholder="your message" class="form-control" >
    <div class="input-group-append">
    <button class="btn btn-primary" type="submit" value="<?php echo $sentTo ?>" name="sendMessage">Send</button>
    </div>
    </div>
    </form>


</div>
<div class='text-center' style='padding-top:20px;'><form action='messages.php'><button type='submit' class='btn btn-warning'>Go Back</button></form></div>


<?php require_once("commonFiles/footer.php")?>