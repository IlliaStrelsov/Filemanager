<?php

class Uploader
{
    public function __construct($link,$target_dir = "uploads/")
    {
        $link = explode("/",$link);
        $link = $link[1];
        $target_dir = "uploads/$link/";
        $this->target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $this->imageFileType = explode(".",$this->target_file);
        echo "<br>";
        echo $this->target_file;
        echo "<br>";
        echo "<br>";
        echo $this->imageFileType[0];
        echo "<br>";

    }

    public $status = 1;//is status 1 => img ca be uploaded elif its 0 so file cannot be uploaded

// In this part we check if file is an image or not
    public function validateImage()

    {

        if (isset($_POST["submit"])) {
            //check if file is img by using getimagesize
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false or strstr($_FILES["fileToUpload"]["type"],"mp4")) {
                $this->status = 1;

            } else {
                $this->status = 0;
                return "File is not an image.";

            }
        }

//All validations for uploaded file


// Check if file already exists
        if (file_exists($this->target_file) and !is_dir($this->target_file)) {
            $this->status = 0;
            return "Sorry, file already exists.";

        }

// Check file size
        if ($_FILES["fileToUpload"]["size"] > 1000000000000000) {
            $this->status = 0;
            return "Sorry, your file is too large.";

        }

// Allow certain file formats
        if ($this->imageFileType[1] != "png" && $this->imageFileType[1] != "jpeg" && $this->imageFileType[1] != "jpg" && $this->imageFileType[1] != "gif" && $this->imageFileType[1] != "mp4") {
            $this->status = 0;
            return "Sorry, only PNG,JPEG,JPG and GIF files are allowed.";

        }
    }

    public function addImage()
    {

// Check if status is 0 or 1
        if ($this->status == 0) {
            return "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->target_file)) {
                return "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                return "Sorry, there was an error uploading your file.";
            }
        }
    }
}

if($_POST["submit"] == "Upload Image"){
    $link = "";
    echo $_FILES["fileToUpload"]["name"][0];
//    $curimg = new Uploader($link);
//    foreach($_FILES["fileToUpload"]["name"] as $file){
//        echo $file;
//        echo "<br>";
//        echo $curimg->validateImage();
//        echo "<br>";
//        echo $curimg->addImage();
//        echo "<br>";
//    }

}
elseif ($_POST["submit"] == "custom"){
    session_start();
    $link = $_SESSION["value"];
}
$curimg = new Uploader($link);
echo $curimg->validateImage();
echo "<br>";
echo $curimg->addImage();
echo "<br>";
echo "<a href='Render.php'>Watch images</a>"
?>









