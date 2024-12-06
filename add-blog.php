<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo blog</title>
</head>
<body>
    <h1> Thêm blog</h1>
    <form method="POST" action="add-blog.php">
        <label for="title">Title:</label><br>
        <input type="text" name="title" required><br>

        <label for="content">Content:</label><br>
        <input type="text" name="content" required><br><br>

        <input type="submit" value= "Tạo blog">
    </form>
</body>
</html>
<?php
include 'connect-db.php';
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $username = $_SESSION['username'];
    // print_r($title);
    // die();
    $taoblog = "INSERT INTO posts(title,content,username) VALUES('$title','$content','$username')";
    // print_r($taoblog);
    // die('aaa');
    $banblog = mysqli_query($conn,$taoblog);
    // print_r($banblog);
    // die('a');
    if($banblog){
    $username = $_SESSION['username'];
    //print_r($banblog);
    //die();
    echo "Tạo blog thành công";
    header('location:trangchu.php');
    }
    else{
        echo "False to tạo blog";
    }
}

?>