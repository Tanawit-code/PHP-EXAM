<?php
session_start();

if (!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
     <div class="container">
        <h2>โปรไฟล์ผู้ใช้</h2>
        <p><strong>ID:</strong> <?php echo $_SESSION["user_id"]; ?></p>
        <p><strong>Username:</strong> <?php echo $_SESSION["username"]; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION["email"]; ?></p>
        <p><a href="logout.php">ออกจากระบบ</a></p>
    </div>
</body>
</html>