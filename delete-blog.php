<h1>Xóa blog</h1>
<?php
include 'connect-db.php';
if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    $xoa = "DELETE FROM posts where post_id = $post_id";
    if(mysqli_query($conn,$xoa)){
        echo "Xóa bài viết thành công";
        header("Location: trangchu.php");
        exit();
    }else{
        echo "Không tìm thấy bài viết để xóa";
    }
}
?>
