<?php
$token = $_GET["token"];
$token_hash = hash("sha256", $token);

// 包含 connect.php 文件以初始化 $conn
require __DIR__ . "/components/connect.php";

// 使用 $conn 进行查询
$sql = "SELECT * FROM users WHERE Reset_passToken = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$token_hash]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user === false) {
    die("token not found");
}

if (strtotime($user["Reset_passExpires"]) <= time()) {
    die("token has expired");
}

// 在这里设置用户ID变量
$user_id = $user['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <!-- 包含 user_header.php 文件 -->
    <?php include 'components/user_header.php'; ?>
    <h1>Reset Password</h1>
    
    <!-- 修改文件名 -->
    <form method="post" action="confirm_pass.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label for="password">New password</label>
        <input type="password" id="password" name="password">
        <label for="password_confirmation">Repeat password</label>
        <input type="password" id="password_confirmation" name="password_confirmation">
        <button>Send</button>
    </form>
</body>
</html>
