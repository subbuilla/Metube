<?php
require_once("commonFiles/header.php");
require_once("files/Classes/SearchResultsProvider.php");
$searchResultsProvider= new SearchResultsProvider($con);
?>

<?php
if(isset($_GET['AddtoPlaylist']))
{
   $result= $searchResultsProvider->addToPlayList($_GET['AddtoPlaylist'],$loggedInUserName);
   if($result)
   {
        header("location:playlist.php?id=");
   }
   else
   {
        echo "<p class='text-danger'>Video Already added to playlist</p>";
   }
}


if(!isset($_GET["orderBy"]) || $_GET["orderBy"] == "Views") {
    $orderBy="Views";
}
else{
    $orderBy="UploadDate";
}

$videos=$searchResultsProvider->getVideosFromPlaylist($loggedInUserName,$orderBy);

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