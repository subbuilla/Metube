<?php require_once("commonFiles/header.php") ?>

<div class='videoSection'>
    <?php
    if($loggedInUserName!="")
    {
        $videoGrid= new VideoGrid($con);
        echo $videoGrid->create(null, "My Videos", false,$loggedInUserName);

        
        echo $videoGrid->create(null, "Recommended", false,$loggedInUserName);
        //, $loggedInUser->getUserName()

        
        
        echo $videoGrid->create(null, "Shared Videos", false,$loggedInUserName);
    }
    else
    {
        $videoGrid= new VideoGrid($con);
        echo $videoGrid->create(null, "Videos you may like", false,$loggedInUserName);
        //, $loggedInUser->getUserName()
    }
    ?>

</div>




<?php require_once("commonFiles/footer.php")?>
    