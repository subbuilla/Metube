<?php
class VideoUploadData {
public $videoDataArray, $title, $description, $privacy, $category, $uploadby,$keyWords;

public function __construct($videoDataArray, $title, $description, $privacy, $category, $uploadby,$keyWords)
{
$this->videoDataArray= $videoDataArray;
$this->title= $title;
$this->description= $description;
$this->privacy= $privacy;
$this->category= $category;
$this->uploadBy= $uploadby;
$this->keyWords=$keyWords;

}


}

?>