<h1> Trang hiện thị blog</h1>
<style>
    h1{text-align: center;}
</style>
<h2> Hiện thị các blog hiện có: </h2></h2>

<?php
    include 'connect-db.php';
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }
    $laydata = "SELECT * FROM posts";
    //print_r($laydata);
    $bandata = mysqli_query($conn,$laydata);
    // print_r($bandata);
    if(mysqli_num_rows($bandata) > 0){
        while($row = mysqli_fetch_assoc($bandata)){
            echo "<div>";
            echo "<h3>" . $row['title'] . "</h3>";
            echo "<p>" . $row['content'] . "</p>";
            echo "<p><b>Đăng bởi: </b>" . $row['username']."</p>";
            echo "<p><b>Ngày đăng: </b> " . $row['created_at']. "</p>";


           // Form để thêm comment
           echo "<form action='comment.php' method='POST'>";
           echo "<label for='comment'>Thêm bình luận:</label><br>";
           echo "<input type=\"text\" name=\"comment\" id=\"comment\" required>";
           echo "<input type='hidden' name='post_id' value='" . $row['post_id'] . "'>";
           echo "<button type='submit'>Gửi bình luận</button>";
           echo "</form>";

            // hiện thị comment
            $post_id = $row['post_id'];
            $comment_query = "SELECT comments.content, comments.created_at, users.username 
                              FROM comments 
                              JOIN users ON comments.user_id = users.id 
                              WHERE comments.post_id = $post_id 
                              ORDER BY comments.created_at DESC";
            $comment_result = mysqli_query($conn, $comment_query);
            
            if(mysqli_num_rows($comment_result) > 0){
                echo "<h4>Bình luận:</h4>";
                while($comment = mysqli_fetch_assoc($comment_result)){
                    echo "<div>";
                    echo "<p><b>" . $comment['username'] . "</b> - " . $comment['created_at'] . "</p>";
                    echo "<p>" . $comment['content'] . "</p>";
                    echo "</div><hr>";
                }
            } else {
                echo "<p>Chưa có bình luận nào.</p>";
            }
            // Thêm nút Xóa blog
            echo "<a href='delete-blog.php?post_id=" . $row['post_id'] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa bài viết này không?\");'>Xóa blog</a>";
            echo "<hr>";
            echo "</div>";
            
            //   echo "<pre>";
            // print_r($row);
            // echo "</pre>";
        //  echo "<a href="delete-blog.php"> Xóa blog </a>";
        }
    }

?>
<a href="add-blog.php">Thêm blog</a>
<a href="update-blog.php">Chỉnh sửa blog</a>
<a href="index.php">Quay lại</a>