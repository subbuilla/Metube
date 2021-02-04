<?php
require_once("commonFiles/header.php");

if(!isset($_POST['downloadButton']))
{
    echo "No URL passed on to page";
    exit();
}
else
{
$vidId=$_POST['downloadButton'];


$query=$con->prepare("select Filepath from Videos where Id=:vd");
$query->bindParam(":vd",$vidId);
$query->execute();
if($query->rowCount()==0)
{
    echo " Invalid video selected";
}
else
{
    $filePath=$query->fetchColumn();

    echo "<div class='text-center'><a href='$filePath' download><button class='btn btn-xl btn-primary'>Click Me to download! <i class='fas fa-download'></i></button></a></div>";
    echo "<div class='text-center'><img src ='success.jpg' alt='success' title='success' style='padding-top:30px; width:600px; height:500px;'></div>";

    echo "<div class='text-center' style='padding-top:30px;'>
    <form method='POST' action='index.php'>
    <button class='btn btn-xl btn-danger' type='submit'>Go back to Home page </button>
    </form></div>";
}

}
 require_once("commonFiles/footer.php");

?>