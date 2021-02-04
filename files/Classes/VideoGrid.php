<?php
class VideoGrid{
    //, $userLoggedInObj
    private $con;
    private $largeMode=false;
    private $gridClass="videoGrid";

    public function __construct($con){

        $this->con= $con;
        //$this->userLoggedInObj= $userLoggedInObj;

    }

    public function create($videos, $title, $showFilter,$loggedInUserName){

        
        if($videos==null && $title== "Recommended")
        {
            $gridItems= $this->generatePublicItems('Public',$loggedInUserName);
        }
        

       else if($videos==null && $title=='Suggestions' && $loggedInUserName=="")
        {
            $gridItems= $this->generatePublicSuggestions('Public');
        }
        else if($videos==null && $title=='Suggestions' && $loggedInUserName!="")
        {
            $gridItems= $this->generatePublicSuggestionsUserLoggedIn('Public',$loggedInUserName);
        }

        else if($videos==null && $title=='My Videos')
        {
            $gridItems=$this->generateMyVideos($loggedInUserName);
        }
        else if($videos==null && $title=='Shared Videos')
        {
            $gridItems=$this->generateSpecialVideos($loggedInUserName);
        }

        else if($videos==null && $title=='Videos you may like')
        {
            $gridItems=$this->generateItems('Public');
        }
        else{
            $gridItems= $this->generateItemsFromVideos($videos);
        }

        $header="";

        if($title != null){
            $header=$this->createGridHeader($title, $showFilter);
        }

        return "$header
        <div class='$this->gridClass'> 
        $gridItems
        </div>";
    }


    public function generateItems($privacy){
        $query=$this->con->prepare("SELECT * FROM Videos where Privacy=:pr ORDER BY RAND()");
        $query->bindParam(":pr",$privacy);
        $query->execute();

        $elementsHtml="";
        while($row= $query->fetch(PDO::FETCH_ASSOC)){
            $video=new Video($this->con, $row);
            $item=new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create();
            //, $this->userLoggedInObj

        }
        return $elementsHtml;
        
        }
        
    





    public function generateMyVideos($loggedInUserName)
    {
        $query=$this->con->prepare("SELECT * FROM Videos where UploadedBy=:ub ORDER BY RAND()");
        $query->bindParam(":ub",$loggedInUserName);
        $query->execute();

        $elementsHtml="";
        while($row= $query->fetch(PDO::FETCH_ASSOC)){
            $video=new Video($this->con, $row);
            $item=new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create();
            //, $this->userLoggedInObj

        }
        return $elementsHtml;
    }





    public function generateSpecialVideos($loggedInUserName)
    {
        $fav='Favorite';
        $friend='Friend';
        $status='Not Blocked';
        $family="Family";
        $colleague='Colleague';

        $query=$this->con->prepare("SELECT * FROM Videos inner join Contact_List on Videos.UploadedBy=Contact_List.userName 
        where contactUserName=:cun and status=:s and((contactType=:fa and Privacy=:fa) or (contactType=:fr and Privacy=:fr) or (contactType=:co and Privacy=:co) or (contactType=:fav and Privacy=:fav)) ORDER BY RAND()");


        $query->bindParam(":cun",$loggedInUserName);
        $query->bindParam(":s",$status);
        $query->bindParam(":fa",$family);
        $query->bindParam(":fr",$friend);
        $query->bindParam(":co",$colleague);
        $query->bindParam(":fav",$fav);
        $query->execute();


        $elementsHtml="";
        while($row= $query->fetch(PDO::FETCH_ASSOC)){
            $video=new Video($this->con, $row);
            $item=new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create();
            //, $this->userLoggedInObj

        }
        return $elementsHtml;
    }

public function generatePublicItems($privacy,$loggedInUserName)
{
    $status='Not Blocked';
    $query=$this->con->prepare("SELECT * FROM Videos inner join user_accounts on Videos.UploadedBy=user_accounts.userName and user_accounts.userName<>:cun left outer join Contact_List on user_accounts.userName=Contact_List.userName and contactUserName=:cun where Privacy=:pr and ( status is null or status=:s)  ORDER BY RAND()");
    $query->bindParam(":pr",$privacy);
    $query->bindParam(":s",$status);
    $query->bindParam(":cun",$loggedInUserName);

        $query->execute();
        $elementsHtml="";
        while($row= $query->fetch(PDO::FETCH_ASSOC)){
            $video=new Video($this->con, $row);
            $item=new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create();
            //, $this->userLoggedInObj

        }
        return $elementsHtml;

}

public function generatePublicSuggestions($privacy)
{
    $query=$this->con->prepare("SELECT * FROM Videos where Privacy=:pr ORDER BY RAND() LIMIT 6");
    $query->bindParam(":pr",$privacy);
        $query->execute();
        $elementsHtml="";
        while($row= $query->fetch(PDO::FETCH_ASSOC)){
            $video=new Video($this->con, $row);
            $item=new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create();
            //, $this->userLoggedInObj

        }
        return $elementsHtml;

}




public function generatePublicSuggestionsUserLoggedIn($privacy,$loggedInUserName)
{
    $status='Not Blocked';
    $query=$this->con->prepare("SELECT * FROM Videos inner join user_accounts on Videos.UploadedBy=user_accounts.userName and user_accounts.userName<>:cun left outer join Contact_List on user_accounts.userName=Contact_List.userName and contactUserName=:cun where Privacy=:pr and ( status is null or status=:s)  ORDER BY RAND() LIMIT 6");
    $query->bindParam(":pr",$privacy);
    $query->bindParam(":s",$status);
    $query->bindParam(":cun",$loggedInUserName);
    $query->execute();







    $fav='Favorite';
        $friend='Friend';
        $status='Not Blocked';
        $family="Family";
        $colleague='Colleague';

        $query1=$this->con->prepare("SELECT * FROM Videos inner join Contact_List on Videos.UploadedBy=Contact_List.userName 
        where contactUserName=:cun and status=:s and((contactType=:fa and Privacy=:fa) or (contactType=:fr and Privacy=:fr) or (contactType=:co and Privacy=:co) or (contactType=:fav and Privacy=:fav)) ORDER BY RAND()");


        $query1->bindParam(":cun",$loggedInUserName);
        $query1->bindParam(":s",$status);
        $query1->bindParam(":fa",$family);
        $query1->bindParam(":fr",$friend);
        $query1->bindParam(":co",$colleague);
        $query1->bindParam(":fav",$fav);
        $query1->execute();


    $elementsHtml="";
    
        while($row= $query->fetch(PDO::FETCH_ASSOC)){
            
            $video=new Video($this->con, $row);
            $item=new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create();
            //, $this->userLoggedInObj
            
        }
        if($query->rowCount()==0)
        {
            while($row= $query1->fetch(PDO::FETCH_ASSOC)){
            
                $video=new Video($this->con, $row);
                $item=new VideoGridItem($video, $this->largeMode);
                $elementsHtml .= $item->create();
            }
        }
        
       
        return $elementsHtml;

}








    public function generateItemsFromVideos($videos){
        $elementsHtml = "";

        foreach($videos as $video) {
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create();
        }

        return $elementsHtml;
        
    }

    public function createGridHeader($title, $showFilter){
        $filter = "";

        if($showFilter) {
            $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            
            $urlArray = parse_url($link);
            $query = $urlArray["query"];

            parse_str($query, $params);

            unset($params["orderBy"]);
            
            $newQuery = http_build_query($params);

            $newUrl = basename($_SERVER["PHP_SELF"]) . "?" . $newQuery;
           
            $filter = "<div class='right'>
                            <span>Order by:</span>
                            <a href='$newUrl&orderBy=uploadDate'>Upload Date</a>
                            <a href='$newUrl&orderBy=Views'>Most Viewed</a>
                            <a href='$newUrl&orderBy=Title'>Sort by Title</a>
                        </div>";
        }



        return "<div class='videoGridHeader'> 
                <div class='left'>
                    $title
                </div>
                $filter
        </div>
        
        ";
    }

    public function createLarge($videos, $title, $showFilter,$loggedInUserName){
            $this->gridClass .= " large";
            $this->largeMode= true;
            return $this->create($videos, $title, $showFilter,$loggedInUserName);
    }



}

?>