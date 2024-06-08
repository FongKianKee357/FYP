<?php

if (!isset($_POST["token"])) {
    die("Token not provided");
}

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/return_sqli.php";

$sql = "SELECT * FROM users WHERE verification_token = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("Token not found");
}

if (strtotime($user["verification_expiry"]) <= time()) {
    die("Token has expired");
}

$name = $_POST["name"];
$password = $_POST["password"];
$password_confirmation = $_POST["password_confirmation"];

if (strlen($password) < 6) {
    die("Password must be at least 6 characters");
}

$specialChars = '/!@#$%^&*()_+-=[]{}|;:,.<>?';
if (!preg_match('/[' . preg_quote($specialChars, '/') . ']/', $password)) {
    die("Password must contain at least one special character");
}

if ($password !== $password_confirmation) {
    die("Passwords must match");
}

$password_hash = sha1($password);

// 更新用户信息并清空验证token
$sql = "UPDATE users SET name = ?, password = ?, verification_token = NULL, verification_expiry = NULL WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssi", $name, $password_hash, $user["id"]);
$stmt->execute();

echo "Password created successfully. You can now login.";

?>
