<?php

class VideoPlayer{

    private $video;

    public function __construct($video){
        $this->video= $video;

    }

    public function create($autoPlay){

        if($autoPlay){

            $autoPlay1 = "autoplay";
        }
        else
        {
            $autoPlay1 = "";
        }
        $filePath= $this->video->getFilepath();
        return "
        <video class='videoPlayer' controls  >
            <source src='$filePath' type='video/mp4'>
            Your browser does not support the video tag
        </video>";

    }

}



?>