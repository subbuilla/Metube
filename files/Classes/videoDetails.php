<?php 
class VideoDetails {
private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }
    public function videoForm()
    {
        $title= $this->title();
        $fileUpload=$this->fileUpload();
        $description=$this->description();
        $privacy=$this->privacy();
        $category=$this->category();
        $uploadButton=$this->uploadButton();
        $keyWords = $this->keyWords();
        return "
        <form action='processing.php' method='POST' enctype='multipart/form-data' style='padding-top:10px;'>
            $title
            $description
            $keyWords
            $privacy
            $category
            $fileUpload
            $uploadButton
            </form>";
    }
    private function fileUpload()
    {

        return "<div class='form-group'>
                    <label for='file'>Upload Video</label>
                    <input type='file' class='form-control-file' id='file' name='fileUpload' required>
                </div>";
    }
    private function title()
    {
        return "<div class='form-group'>
        <label for='title'>Title</label>
        <input type='text' class='form-control' id='title' name='title' required placeholder='Type out title of the video'>
        </div>";
    }
    private function description()
    {
        return "<div class='form-group'>
        <label for='description'>Description</label>
        <textarea class='form-control'name='description' id='description' cols='30' rows='10' required placeholder='Type out description of the video'></textarea>
        </div>";
    }

    private function keyWords()
    {
        return "<div class='form-group'>
        <label for='keywords'>Key Words</label>
        <input type='text' class='form-control' id='keywords' name='keywords' required placeholder='Type out keywords seperated by a comma'>
        </div>";
    }




    
    private function privacy()
    {
        return "<div class='form-group'>
        <label for='privacy'>Privacy</label>
        <select class='form-control' id='privacy' name='privacy' placeholder='Set Privacy'>
            <option value='Public'>Public</option>
            <option value='Private'>Private</option>
            <option value='Friend'>Friends</option>
            <option value='Family'>Family</option>
            <option value='Favorite'>Favorites</option>
            <option value='Colleague'>Colleagues</option>

        </select>
        </div>";
    }
    private function category()
    {
        $query = $this->con->prepare("Select * from Categories");
        $query->execute();
        $html="<div class='form-group'>
        <label for='category'>Category</label>
        <select class='form-control' id='category' name='category'>";

        while($row=$query->fetch(PDO::FETCH_ASSOC))
        {
            $category=$row["Category"];
            $id=$row["Id"];
           $html.=  "<option value='$id'>$category</option>";
        }
        $html .= "</select>
        </div>";
        return $html;
    }

    private function uploadButton()
    {
        return "<button type='submit' class='btn btn-primary' name='uploadButton'>Upload <i class='fas fa-upload'></i></button>";
    }
}
?>