<?php
include 'connect-db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    // Thêm bình luận vào database
    $sql = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES ('$post_id', '$user_id', '$comment', NOW())";
    if (mysqli_query($conn, $sql)) {
        echo "Bình luận đã được thêm!";
    } else {
        echo "Có lỗi xảy ra khi thêm bình luận: " . mysqli_error($conn);
    }

    header("Location: trangchu.php");
    exit;
}
?>
