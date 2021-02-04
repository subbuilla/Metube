<?php
      require_once("commonFiles/header.php"); 
      require_once("files/Classes/Properties.php");
      require_once("files/Classes/channelClass.php");

      $channelClass =new ChannelClass($con);

?>



<?php 
if(isset($_POST['createButton']))
    {
       $result1= $channelClass->createChannel($loggedInUserName,$_POST['channelName']);
       if($result1)
       {
        header("channels.php");   
        }
    }

    if(isset($_POST['updateChannelButton']))
    {
        $result1= $channelClass->updateChannelName($loggedInUserName,$_POST['updatechannelName']);
       if($result1)
       {
        header("location:channels.php");   
        }
    }


?>
<div class='container' style='padding-top:10px;'>
<div class='jumbotron'>
<?php



$result=$channelClass->getChannel($loggedInUserName);

if($result=="")
{
    echo "<form action='channels.php' method='POST'>
    <div class='form-group'>
    <label for='channelName'>Channel Name:</label>    
    <input type='text' name='channelName' class='form-control' id='channelName' required placeholder='example99'>";
    echo $channelClass->displayError(Properties::$channelUniqueError); 
    echo"</div>
    <div class='text-right' style='margin-top:20px'>
    <button type='submit' class='btn btn-primary' name='createButton'>Create </button>
    

</div></form>";
}
else
{
    echo $result;
}

if(isset($_POST['channeledit']))
{
    echo "<form action='channels.php' method='POST'>
    <div class='form-group'>
    <label for='updatechannelName'>Update Channel Name:</label>    
    <input type='text' name='updatechannelName' class='form-control' id='updatechannelName' required placeholder='example99'>";
    echo $channelClass->displayError(Properties::$channelUniqueError); 
    echo"</div>
    <div class='text-right' style='margin-top:20px'>
    <button type='submit' class='btn btn-primary' name='updateChannelButton'>Update</button></div></form>";
}
echo $channelClass->displayError(Properties::$channelUniqueError); 

?>

</div>
</div>







<?php require_once("commonFiles/footer.php")?>