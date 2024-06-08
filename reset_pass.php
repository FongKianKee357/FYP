<?php
$token = $_GET["token"] ?? null;

if ($token === null) {
    die("Token not found");
}

$token_hash = hash("sha256", $token);

// 包含 connect.php 文件以初始化 $conn
require __DIR__ . "/components/connect.php";

// 使用 $conn 进行查询
$sql = "SELECT * FROM users WHERE Reset_passToken = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$token_hash]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user === false) {
    die("Token not found or expired");
}

// 在这里设置用户ID变量
$user_id = $user['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];
    $specialChars = '/!@#$%^&*()_+-=[]{}|;:,.<>?';

    if (strlen($password) < 6){
        $message[] = 'Password must be at least 6 characters';
    } else if (!preg_match('/[' . preg_quote($specialChars, '/') . ']/', $password)){
        $message[] = 'Password must contain at least one special character';
    } else if ($password !== $password_confirmation){
        $message[] = 'Passwords must match';
    } else {
        $password_hash = sha1($password); // 使用 SHA1 哈希密码
        $sql = "UPDATE users
                SET password = ?,
                    Reset_passToken = NULL,
                    Reset_passExpires = NULL
                WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$password_hash, $user["id"]]);
        
        $message[] = 'Password updated. You can now login.';
        
        header("Refresh: 2; URL = http://localhost/FYP/user_login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- 包含 user_header.php 文件 -->
    <?php include 'components/user_header.php'; ?>

    <section class="form-container">
        <form method="post" action="">
            <h3>Reset Password</h3>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <input type="password" id="password" name="password" class="box" placeholder="New Password" required>
            <input type="password" id="password_confirmation" name="password_confirmation" class="box" placeholder="Repeat Password" required>
            <button type="submit" class="btn">Send</button>
        </form>
    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>
</html>
