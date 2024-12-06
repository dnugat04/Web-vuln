<?php 
if(isset($_POST['update_avatar'])){
    // $avt_sql = "UPDATE avatars SET id=1, path_to_image='$target_file',user_id='$user_id'";
    $avt_sql = "INSERT INTO avatars (id,path_to_image) VALUES (1,'$target_file')";
    // print_r($avt_sql);
    // die();
    $avt_result = mysqli_query($conn,$avt_sql);
    print_r($avt_result);
    die();
    if($avt_result){
        // print_r(mysqli_num_rows( $avt_result ));
        // die();
        $avt_user = $avt_result->fetch_assoc();
        print_r($avt_user);
        die();
    } else{
        echo "Fail to lưu ảnh";
        exit();
    }

}
?>
// info.php cũ
<?php
include 'connect-db.php';
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
// print_r($user_id);
// die();
require_once 'connect-db.php';
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user= $result->fetch_assoc();
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}
// Xử lý avatar
$target_dir = "uploads/";
$target_file = $target_dir . $_FILES["avatar"]["name"];
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check xem ảnh đã tồn tại hay chữa
// Đúng định dạng như jpg,png,jpeg...
// Check if image file is a actual image or fake image
if(isset($_POST['submit'])){
    move_uploaded_file($_FILES["avatar"]["tmp_name"],$target_file);
    echo " <br> <img src = '$target_file' width='300'> ";
    echo " File được upload tại " . $target_file;
    $uploadOk = 1;
}
if(isset($_POST['update_avatar'])){
    $default_avatar_path = 'uploads/avatars/default.jpg';
    $user_id = 1; // ID của user cần gắn ảnh đại diện mặc định
    
    $sql = "INSERT INTO avatars (path_to_image, user_id) VALUES ('$default_avatar_path', $user_id)";
    if (mysqli_query($conn, $sql)) {
        echo "Avatar mặc định đã được thêm!";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng</title>
</head>
<body>
    <h1>Thông tin người dùng</h1>
    <p>ID: <?php echo $user['id']; ?> </p>
    <p>Tên đăng nhập: <?php echo $user['username']; ?> </p>
    <p>Email: <?php echo $user['email']; ?> </p>
    <p>Giới tính: <?php echo $user['gioitinh']; ?> </p>

    <h2>Cập nhật ảnh đại diện</h2>
    <form action="info.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="avatar" id="avatar">
        <input type="submit" value="Upload Avatar" name="submit"> <br>
        <input type="submit" value="Cập nhật Avatar" name="update_avatar">
    </form>
    <p> Ảnh đại diện: <?php echo $avt_user[path_to_image];?> </p>
</body>
</html>
<a href="#"> Reset Password</a>
<a href="index.php">Quay lại</a>


// trangchu.php
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
           echo "<textarea name='comment' id='comment' rows='3' cols='50' required></textarea><br>";
           echo "<input type='hidden' name='post_id' value='" . $row['post_id'] . "'>";
           echo "<button type='submit'>Gửi bình luận</button>";
           echo "</form>";

            // hiện thị comment
            
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

// lỗi khóa ngoại 
ALTER TABLE comments
DROP FOREIGN KEY comments_ibfk_1;

ALTER TABLE comments
ADD CONSTRAINT comments_ibfk_1
FOREIGN KEY (post_id) REFERENCES posts(post_id)
ON DELETE CASCADE;  -- Hoặc ON DELETE SET NULL tùy theo yêu cầu


Fatal error: Uncaught mysqli_sql_exception: Cannot delete or update a parent row: a foreign key constraint fails (`babyweb`.`comments`, CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`)) in C:\xampp\htdocs\myweb\src\delete-blog.php:7 Stack trace: #0 C:\xampp\htdocs\myweb\src\delete-blog.php(7): mysqli_query(Object(mysqli), 'DELETE FROM pos...') #1 {main} thrown in C:\xampp\htdocs\myweb\src\delete-blog.php on line 7