<?php require_once("commonFiles/header.php"); 
      require_once("files/Classes/videoDetails.php"); ?>


<div class='container' style='padding-top:10px;'>
<div class='jumbotron'>
    <h1 class="text-dark">Upload your Video</h1>
<?php 
try{
$inputForm = new videoDetails($con);
echo $inputForm->videoForm();
}
catch(Exception $e)
{
echo "Some Error Occured: ".$e->get_message();
}

?>

</div>
</div>

<?php require_once("commonFiles/footer.php")?>