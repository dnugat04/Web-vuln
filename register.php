<?php
include 'connect-db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $gioitinh = $_POST['gioitinh'];

    $check_exist_username_query = "SELECT * FROM users WHERE username ='$username'";
    $check_exist_username_result = mysqli_query($conn,$check_exist_username_query);

    if(mysqli_num_rows($check_exist_username_result) > 0){
        echo " Tài khoản đã tồn tại. Vui lòng nhập tài khoản khác";
    } else {
        $insert_sql = "INSERT INTO users (username,password,email,gioitinh) VALUES ('$username','$password','$email','$gioitinh')";
        $insert_result = mysqli_query($conn,$insert_sql);

        if($insert_result){
            echo "Đăng ký thành công!";
            header('Location: login.php');
         }
         else{
            echo "Đăng kí thật bại!";
         }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang đăng ký</title>
</head>
<body>
    <form method="POST" action="register.php">

    <label for="username">User name:</label><br>
    <input type="text" id="username" name="username"><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br>

    <label for="email">Email: </label><br>
    <input type="text" id="email" name="email"><br>

    <label>Giới Tính:</label>
    <input type="radio" id="male" name="gioitinh" value="Nam">
    <label for="male">Nam</label>
    
    <input type="radio" id="female" name="gioitinh" value="Nữ">
    <label for="female">Nữ</label><br>
    
    <input type="submit" value="Đăng Ký">
    </form>
</body>
</html>