<?php 
require_once("commonFiles/header.php");
require_once("files/Classes/VideoUploadData.php");
require_once("files/Classes/VideoProcessor.php");


if(!isset($_POST["uploadButton"])){
echo "No file sent to page";
exit();
}

//file upload data
$videoUploadData= new VideoUploadData($_FILES["fileUpload"],$_POST["title"],$_POST["description"],$_POST["privacy"],$_POST["category"],$loggedInUserName,$_POST["keywords"]);

//processing upload data
$videoProcessor=new VideoProcessor($con);
$wasSuccessfull=$videoProcessor->upload($videoUploadData);

if($wasSuccessfull)
{
    echo "successfully uploaded";
}

?>


<?php require_once("commonFiles/footer.php")?>