<?php
require_once("commonFiles/header.php");
require_once("files/Classes/SearchResultsProvider.php");


$q = intval($_GET['q']);
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
$videos=$searchResultsProvider->getVideosbyCategory($q,$orderBy,$loggedInUserName);


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
