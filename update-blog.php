<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa blog</title>
</head>
    <h1> Chỉnh sửa blog</h1>
    <form method="POST" action="update-blog.php">
        
      <label for="postid">ID post:</label><br>
        <input type="number" name="postid" required><br>

        <label for="title">Title:</label><br>
        <input type="text" name="title" required><br>

        <label for="content">Content:</label><br>
        <input type="text" name="content" required><br><br>

        <input type="submit" value= "Chỉnh sửa blog">

    </form>
    
</body>
</html>
<?php
include 'connect-db.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $postid = $_POST['postid'];
    $title1 = $_POST['title'];
    $content1 = $_POST['content'];

    $update = "UPDATE posts SET title='$title1', content='$content1' WHERE post_id ='$postid'";
    $getupdate = mysqli_query($conn,$update);
    // print_r($getupdate);
    // print_r($update);
    if($getupdate){
        echo " Cập nhật bài viết thành công";
        header('Location: trangchu.php');
    }else{
        echo "fail to update";
    }

}

?>