<h1> Trang chủ </h1>
<a href="#"> Chức năng Upload </a>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</body>
</html>
<?php
//Hoc chung nang upload 3/12/2024

    $target_dir = "uploads/";
    // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $_FILES["fileToUpload"]["name"];
    // print_r($_FILES);
    // print_r($target_file);
    //print_r(basename($_FILES["fileToUpload"]["name"]));
    //die();
    $uploadOk = 1;
    // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); //kiểm tra đuôi file
    // $imageFileType = strtolower(pathinfo($target_file,$_FILES["fileToUpload"]["type"]));
    // $imaegeFileType = ($target_file,$_FILES["fileToUpload"]["type"]);
    // how to get extension in php
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
   // print_r($imageFileType);
    //die();
    // check if file already exits
    if(file_exists($target_file)){
        // print_r(file_exists($target_file));
        // die();  
        echo "Sorry, file đã tồn tại";
        $uploadOk = 0;
        exit();
    }   

    // allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "php" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
         $uploadOk = 0;
        exit();
}
    // Check if image file is a actual image or fake image
/*    if(isset($_POST['submit'])){
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false){
            echo "File is an image - " . $check["mime"] . ".";
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            // print_r(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file));
            die();
            echo " <br> <img src = '$target_file' width='300'> ";
            $uploadOk = 1;
        } else{
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
*/
    if(isset($_POST['submit'])){
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        echo " <br> <img src = '$target_file' width='300'> ";
        echo " File được upload tại " . $target_file;
        $uploadOk = 1;
    }
?>
