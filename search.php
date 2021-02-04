<?php
require_once("commonFiles/header.php");
require_once("files/Classes/SearchResultsProvider.php");


if(!isset($_GET["term"]) || $_GET["term"] == ""){
    echo "You must enter something in search bar";
    exit();
}
$term=$_GET["term"];

if(!isset($_GET["orderBy"]) || $_GET["orderBy"] == "Views") {
    $orderBy="Views";
}
else if($_GET["orderBy"]=="Title")
{
    $orderBy="Title";   
}
else{
    $orderBy="UploadDate";
}

$searchResultsProvider= new SearchResultsProvider($con);
$videos= $searchResultsProvider->getVideos($term, $orderBy,$loggedInUserName); 

$videoGrid= new VideoGrid($con);

?>

<div class="largeVideoGridContainer">
    <?php
        if(sizeof($videos) > 0){
            echo $videoGrid->createLarge($videos, sizeof($videos) . " Results Found ", true,$loggedInUserName);
        }
        else{
            echo "No Results found, Please try with another search"; 
        }

    ?>


</div>







<?php
require_once("commonFiles/footer.php");
?>