<?php

class SearchResultsProvider{
    private $con;

    public function __construct($con){
        $this->con= $con;
        //$this->userLoggedInObj= $userLoggedInObj;
    }
    
    public function getVideos($term, $orderBy,$loggedInUserName){
        
        $privacy='Public';
        // $query= $this->con->prepare("SELECT * FROM Videos WHERE (Keywords LIKE CONCAT('%', :term, '%')
        //                             OR UploadedBy LIKE CONCAT('%', :term, '%')) and Privacy=:pr  ORDER BY $orderBy DESC ");
        // $query->bindParam(":term",$term); 
        // $query->bindParam(":pr",$privacy);
        // $query->execute();

        $status='Not Blocked';
        $query1= $this->con->prepare("SELECT * FROM Videos inner join user_accounts on Videos.UploadedBy=user_accounts.userName and user_accounts.userName<>:cun left outer join Contact_List on user_accounts.userName=Contact_List.userName and contactUserName=:cun 
        WHERE (Keywords LIKE CONCAT('%', :term, '%')
        OR UploadedBy LIKE CONCAT('%', :term, '%')) and Privacy=:pr and ( status is null or status=:s)  ORDER BY $orderBy DESC ");
        $query1->bindParam(":term",$term); 
        $query1->bindParam(":pr",$privacy);
        $query1->bindParam(":s",$status);
        $query1->bindParam(":cun",$loggedInUserName);
        $query1->execute();



        $fav='Favorite';
        $friend='Friend';
        $family="Family";
        $colleague='Colleague';

        $query2=$this->con->prepare("SELECT * FROM Videos inner join Contact_List on Videos.UploadedBy=Contact_List.userName 
        where (Keywords LIKE CONCAT('%', :term, '%')
        OR UploadedBy LIKE CONCAT('%', :term, '%')) and contactUserName=:cun and status=:s and((contactType=:fa and Privacy=:fa) or (contactType=:fr and Privacy=:fr) or (contactType=:co and Privacy=:co) or (contactType=:fav and Privacy=:fav)) ORDER BY RAND()");

        $query2->bindParam(":term",$term); 
        $query2->bindParam(":cun",$loggedInUserName);
        $query2->bindParam(":s",$status);
        $query2->bindParam(":fa",$family);
        $query2->bindParam(":fr",$friend);
        $query2->bindParam(":co",$colleague);
        $query2->bindParam(":fav",$fav);
        $query2->execute();


        $query3=$this->con->prepare("SELECT * FROM Videos where UploadedBy=:ub and (Keywords LIKE CONCAT('%', :term, '%')
        OR UploadedBy LIKE CONCAT('%', :term, '%')) ORDER BY RAND()");
        $query3->bindParam(":ub",$loggedInUserName);
        $query3->bindParam(":term",$term); 
        $query3->execute();

        
       
        $videos=array();
        while($row = $query1->fetch(PDO::FETCH_ASSOC)){
            $video= new Video($this->con, $row);
            array_push($videos, $video);
        }
        while($row = $query2->fetch(PDO::FETCH_ASSOC)){
            $video= new Video($this->con, $row);
            array_push($videos, $video);
        }
        while($row = $query3->fetch(PDO::FETCH_ASSOC)){
            $video= new Video($this->con, $row);
            array_push($videos, $video);
        }



        function cmp($a, $b) {
            return $a->getViews()-$b->getViews();
        }
        function cmp1($a, $b) {
            return strtotime($a->getUploadDate())-strtotime($b->getUploadDate());
        }
        function cmp2($a, $b) {
            return strtoupper($a->getTitle())>strtoupper($b->getTitle());
        }

        if($orderBy=='Views')
        {
        usort($videos, "cmp");
        }
        else if($orderBy=='UploadDate')
        {
        usort($videos, "cmp1");
        }
        else if($orderBy=='Title')
        {
            usort($videos, "cmp2");
            return $videos;
        }

        //usort($videos, $orderBy); 
        return array_reverse($videos);
    }


    public function getVideosbyCategory($category,$orderBy,$loggedInUserName)
    {
       
            
        $privacy='Public';


        $status='Not Blocked';

        $query1= $this->con->prepare("SELECT * FROM Videos inner join user_accounts on Videos.UploadedBy=user_accounts.userName and user_accounts.userName<>:cun left outer join Contact_List on user_accounts.userName=Contact_List.userName and contactUserName=:cun 
        WHERE Category=:ca and Privacy=:pr and ( status is null or status=:s)  ORDER BY $orderBy DESC ");
        $query1->bindParam(":pr",$privacy);
        $query1->bindParam(":s",$status);
        $query1->bindParam(":cun",$loggedInUserName);
        $query1->bindParam(":ca",$category);
        $query1->execute();



        $fav='Favorite';
        $friend='Friend';
        $family="Family";
        $colleague='Colleague';

        $query2=$this->con->prepare("SELECT * FROM Videos inner join Contact_List on Videos.UploadedBy=Contact_List.userName 
        where Category=:ca and contactUserName=:cun and status=:s and((contactType=:fa and Privacy=:fa) or (contactType=:fr and Privacy=:fr) or (contactType=:co and Privacy=:co) or (contactType=:fav and Privacy=:fav)) ORDER BY RAND()");

        $query2->bindParam(":cun",$loggedInUserName);
        $query2->bindParam(":s",$status);
        $query2->bindParam(":fa",$family);
        $query2->bindParam(":fr",$friend);
        $query2->bindParam(":co",$colleague);
        $query2->bindParam(":fav",$fav);
        $query2->bindParam(":ca",$category);
        $query2->execute();


        $query3=$this->con->prepare("SELECT * FROM Videos where UploadedBy=:ub and Category=:ca ORDER BY RAND()");
        $query3->bindParam(":ub",$loggedInUserName);
        $query3->bindParam(":ca",$category);
        $query3->execute();

    
        

        $videos=array();
        while($row = $query1->fetch(PDO::FETCH_ASSOC)){
            $video= new Video($this->con, $row);
            array_push($videos, $video);
        }
        while($row = $query2->fetch(PDO::FETCH_ASSOC)){
            $video= new Video($this->con, $row);
            array_push($videos, $video);
        }
        while($row = $query3->fetch(PDO::FETCH_ASSOC)){
            $video= new Video($this->con, $row);
            array_push($videos, $video);
        }



        function cmp($a, $b) {
            return $a->getViews()-$b->getViews();
        }
        function cmp1($a, $b) {
            return strtotime($a->getUploadDate())-strtotime($b->getUploadDate());
        }
        function cmp2($a, $b) {
            return strtoupper($a->getTitle())>strtoupper($b->getTitle());
        }

        if($orderBy=='Views')
        {
        usort($videos, "cmp");
        }
        else if($orderBy=='UploadDate')
        {
        usort($videos, "cmp1");
        }
        else if($orderBy=='Title')
        {
            usort($videos, "cmp2");
            return $videos;
        }

        //usort($videos, $orderBy); 
        return array_reverse($videos);

    }

    public function getVideosFromPlaylist($userName,$orderBy)
    {
        $query=$this->con->prepare("select * from Playlist inner join Videos on Videos.Id=Playlist.videoId where userName=:un order by $orderBy DESC");
        $query->bindParam(":un",$userName);
        $query->execute();

        $videos=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $video= new Video($this->con, $row);
            array_push($videos, $video);
        }
        return $videos;


    }
    public function getVideosFromFavList($userName,$orderBy)
    {
        $query=$this->con->prepare("select * from Favoritelist inner join Videos on Videos.Id=Favoritelist.videoId where userName=:un order by $orderBy DESC");
        $query->bindParam(":un",$userName);
        $query->execute();

        $videos=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $video= new Video($this->con, $row);
            array_push($videos, $video);
        }
        return $videos;
    }

    public function addToPlayList($videoId,$userName)
    {
        $query=$this->con->prepare("select * from Playlist where videoId=:vi and userName=:un");
        $query->bindParam(":un",$userName);
        $query->bindParam(":vi",$videoId);
        $query->execute();

        if($query->rowCount()==0)
        {
            $query1=$this->con->prepare("insert into Playlist(videoId,userName) values(:vi,:un)");
            $query1->bindParam(":un",$userName);
            $query1->bindParam(":vi",$videoId);
            return $query1->execute();
        }
        else
        {
            return false;
        }


    }
    public function addToFavList($videoId,$userName)
    {
        $query=$this->con->prepare("select * from Favoritelist where videoId=:vi and userName=:un");
        $query->bindParam(":un",$userName);
        $query->bindParam(":vi",$videoId);
        $query->execute();

        if($query->rowCount()==0)
        {
            $query1=$this->con->prepare("insert into Favoritelist(videoId,userName) values(:vi,:un)");
            $query1->bindParam(":un",$userName);
            $query1->bindParam(":vi",$videoId);
            return $query1->execute();
        }
        else
        {
            return false;
        }
    }


}

?>