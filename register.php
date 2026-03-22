<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($email) || empty($password)) {
        $message = "<p class='error'>กรุณากรอกข้อมูลให้ครบ</p>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $checkSql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "<p class='error'>Username หรือ Email นี้มีอยู่แล้ว</p>";
        } else {
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashedPassword);

            if ($stmt->execute()) {
                $message = "<p class='success'>สมัครสมาชิกสำเร็จ <a href='login.php'>ไปหน้า Login</a></p>";
            } else {
                $message = "<p class='error'>เกิดข้อผิดพลาด</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>สมัครสมาชิก</h2>
        <?php echo $message; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="ชื่อผู้ใช้">
            <input type="email" name="email" placeholder="อีเมล">
            <input type="password" name="password" placeholder="รหัสผ่าน">
            <button type="submit">สมัครสมาชิก</button>
        </form>
        <p>มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
    </div>
</body>
</html>