<?php
session_start();
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $message = "<p class='error'>กรุณากรอกข้อมูลให้ครบ</p>";
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["email"] = $user["email"];

                header("Location: profile.php");
                exit();
            } else {
                $message = "<p class='error'>รหัสผ่านไม่ถูกต้อง</p>";
            }
        } else {
            $message = "<p class='error'>ไม่พบบัญชีผู้ใช้</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>เข้าสู่ระบบ</h2>
        <?php echo $message; ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="อีเมล">
            <input type="password" name="password" placeholder="รหัสผ่าน">
            <button type="submit">เข้าสู่ระบบ</button>
        </form>
        <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
    </div>
</body>
</html>