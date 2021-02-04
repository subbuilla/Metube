<?php
class VideoProcessor{
private $con;
private $sizeLimit=300000000;
private $allowedFileType= array("mp4","flv","webm","mkv","avi","mov","mpeg");

// private $ffmpegPath = "ffmpeg/mac/xampp-VM/ffmpeg";
// private $ffprobePath = "ffmpeg/mac/xampp-VM/ffprobe";
// private $ffmpegPath = "ffmpeg/mac/regular-xampp/ffmpeg";
// private $ffprobePath = "ffmpeg/mac/regular-xampp/ffprobe";

public function __construct($con){
    $this->con=$con;
}

public function upload($videoUploadData){
    $targetDir = "uploads/videos/";
    $videoData = $videoUploadData->videoDataArray;
    
    $tempFilePath = $targetDir . uniqid() . basename($videoData["name"]);

    $tempFilePath = str_replace(" ", "_", $tempFilePath);

    $isvalidData= $this->processData($videoData,$tempFilePath);
 

    if(!$isvalidData) {
        return false;
    }

    if(move_uploaded_file($videoData["tmp_name"], $tempFilePath)) {
        
        //$finalFilePath= $targetDir . uniqid() . ".mp4";

        if(!$this->insertVideoData($videoUploadData,$tempFilePath)){
            return false;
        }
        $cmd="chmod -R 644 $tempFilePath";
        $output1=array();
        exec($cmd, $output1, $returnCode);
        // if(!$this->deleteFile($tempFilePath)){
        //     echo "deletion failed";
        //     return false;
        // }
        // if(!$this->convertVideoToMp4($tempFilePath, $finalFilePath)) {
        //     echo "Upload failed\n";
        //     return false;
        // }
        // if(!$this->generateThumbnails($tempFilePath)) {
        //     echo "Upload failed - could not generate thumbnails\n";
        //     return false;
        // }

        return true;
    }

}

// Checking format of the file 
private function processData($videoData,$filePath){
    //extracting file extention
    $videoType=pathinfo($filePath, PATHINFO_EXTENSION);


    if(!$this->isValidSize($videoData)){
        echo "File too Large. Can't be more than" . $this->sizeLimit." bytes";
        return false;
    }
    elseif(!$this->isValidType($videoType)){
        echo "Invalid File format";
        return false;
    }
    else if($this->hasError($videoData)) {
        echo "Error code: " . $videoData["error"];
        return false;
    }

    return true;
}

    //check size of the file 
    private function isValidSize($data){
    return $data["size"]<=$this->sizeLimit;
    }

    private function isValidType($type){
    $lowercased=strtolower($type);
    return in_array($lowercased, $this->allowedFileType);
    } 
    private function hasError($data) {
        return $data["error"] != 0;
    }

    private function insertVideoData($uploadData, $filePath) {
        $query = $this->con->prepare("INSERT INTO Videos(Title, UploadedBy, Description, Privacy, Category, FilePath, Keywords)
                                        VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath, :keyWords)");

        $query->bindParam(":title", $uploadData->title);
        $query->bindParam(":uploadedBy", $uploadData->uploadBy);
        $query->bindParam(":description", $uploadData->description);
        $query->bindParam(":privacy", $uploadData->privacy);
        $query->bindParam(":category", $uploadData->category);
        $query->bindParam(":keyWords", $uploadData->keyWords);
        $query->bindParam(":filePath", $filePath);

        return $query->execute();
    }

    // private function deleteFile($filePath){
    //     if(!unlink($filePath)){
    //         echo "could not delete the file \n";
    //         return false;
    //     }
    //     return true;    

    // }

    // public function convertVideoToMp4($tempFilePath, $finalFilePath) {
    //     $cmd = "$this->ffmpegPath -i $tempFilePath $finalFilePath 2>&1";

    //     $outputLog = array();
    //     exec($cmd, $outputLog, $returnCode);
        
    //     if($returnCode != 0) {
    //         //Command failed
    //         foreach($outputLog as $line) {
    //             echo $line . "<br>";
    //         }
    //         return false;
    //     }

    //     return true;
    // }




    
    // public function generateThumbnails($filePath) {

    //     $thumbnailSize = "105x59";
    //     $numThumbnails = 2;
    //     $pathToThumbnail = "uploads/videos/thumbnails";
        
    //     $duration = $this->getVideoDuration($filePath);
        
    //      $videoId = $this->con->lastInsertId();
         
    //      $this->updateDuration($duration, $videoId);

    //     for($num = 1; $num <= $numThumbnails; $num++) {
    //         $imageName = uniqid() . ".jpg";
    //         $interval = ($duration * 0.8) / $numThumbnails * $num;
    //         $fullThumbnailPath = "$pathToThumbnail/$videoId-$imageName";

    //         $cmd = "$this->ffmpegPath -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";

    //         $outputLog = array();
    //         exec($cmd, $outputLog, $returnCode);
            
    //         if($returnCode != 0) {
    //             //Command failed
    //             foreach($outputLog as $line) {
    //                 echo $line . "<br>";
    //             }
    //         }

    //         $query = $this->con->prepare("INSERT INTO Thumbnails(VideoId, Filepath, Selected)
    //                                     VALUES(:videoId, :filePath, :selected)");
    //         $query->bindParam(":videoId", $videoId);
    //         $query->bindParam(":filePath", $fullThumbnailPath);
    //         $query->bindParam(":selected", $selected);

    //         $selected = $num == 1 ? 1 : 0;

    //         $success = $query->execute();

    //         if(!$success) {
    //             echo "Error inserting thumbnail\n";
    //             return false;
    //         }
    //     }

    //     return true;
    // }

    // private function getVideoDuration($filePath) {
    //     return (int)shell_exec("$this->ffprobePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    // }

    // private function updateDuration($duration, $videoId) {
        
    //     $hours = floor($duration / 3600);
    //     $mins = floor(($duration - ($hours*3600)) / 60);
    //     $secs = floor($duration % 60);   
        
    //     $hours = ($hours < 1) ? "" : $hours . ":";
    //     $mins = ($mins < 10) ? "0" . $mins . ":" : $mins . ":";
    //     $secs = ($secs < 10) ? "0" . $secs : $secs;

    //     $duration = $hours.$mins.$secs;

    //     $query = $this->con->prepare("UPDATE Videos SET Duration=:duration WHERE Id=:Id");
    //     $query->bindParam(":duration", $duration);
    //     $query->bindParam(":Id", $videoId);
    //     $query->execute();
        
    // }
}
?>
