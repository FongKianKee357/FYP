<?php

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

// 修改文件名
$mysqli = require __DIR__ . "/return_sqli.php";

$sql = "SELECT * FROM users
        WHERE Reset_passToken = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["Reset_passExpires"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 6) {
    die("Password must be at least 6 characters");
}

$specialChars = '/!@#$%^&*()_+-=[]{}|;:,.<>?';
if (!preg_match('/[' . preg_quote($specialChars, '/') . ']/', $_POST["password"])) {
    die("Password must contain at least one special character");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = sha1($_POST["password"]);

$sql = "UPDATE users
        SET password = ?,
            Reset_passToken = NULL,
            Reset_passExpires = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["id"]);

$stmt->execute();

echo "Password updated. You can now login.";

?>
