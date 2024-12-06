<?php
include 'connect-db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin user
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}

// Xử lý upload avatar
if (isset($_POST['submit'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . $_FILES["avatar"]["name"];
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  /*  // Kiểm tra định dạng ảnh
    $valid_formats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $valid_formats)) {
        echo "Chỉ cho phép các định dạng: JPG, JPEG, PNG, GIF.";
        $uploadOk = 0;
    }
 */
    // Di chuyển file ảnh
    if ($uploadOk && move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        echo "<br> <img src='$target_file' width='300'>";
        echo "<br> File đã được upload tại: $target_file";

        // Cập nhật avatar vào database
        $sql_update_avatar = "INSERT INTO avatars (path_to_image, user_id) VALUES ('$target_file', '$user_id') 
                              ON DUPLICATE KEY UPDATE path_to_image='$target_file'";
        if ($conn->query($sql_update_avatar)) {
            echo "<br> Avatar đã được cập nhật!";
        } else {
            echo "<br> Lỗi: " . $conn->error;
        }
    }
}

// Lấy avatar từ database
$sql_avatar = "SELECT path_to_image FROM avatars WHERE user_id = '$user_id'";
$result_avatar = $conn->query($sql_avatar);

if ($result_avatar->num_rows > 0) {
    $avt_user = $result_avatar->fetch_assoc();
    $avatar_path = $avt_user['path_to_image'];
} else {
    $avatar_path = 'uploads/avatar/default.jpg'; // Avatar mặc định nếu chưa có
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

    <h2>Ảnh đại diện</h2>
    <img src="<?php echo $avatar_path . '?t=' . time(); ?>" alt="Avatar" width="150" height="150">

    <h2>Cập nhật ảnh đại diện</h2>
    <form action="info.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="avatar" id="avatar">
        <input type="submit" value="Upload Avatar" name="submit">
    </form>

    <a href="index.php">Quay lại</a>
</body>
</html>
