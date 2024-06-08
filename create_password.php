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
$specialChars = '/!@#$%^&*()_+-=[]{}|;:,.<>?';

if (strlen($password) < 6) {
    $message = 'Password must be at least 6 characters';
} elseif (!preg_match('/[' . preg_quote($specialChars, '/') . ']/', $password)) {
    $message = 'Password must contain at least one special character';
} elseif ($password !== $password_confirmation) {
    $message = 'Passwords must match';
} else {
    $password_hash = sha1($password);

    // 更新用户信息并清空验证token
    $sql = "UPDATE users SET name = ?, password = ?, verification_token = NULL, verification_expiry = NULL WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssi", $name, $password_hash, $user["id"]);
    $stmt->execute();

    $message = 'Password created successfully. You can now login.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section class="form-container-f">
        <h1>Create Password</h1>
        <?php if (isset($message)): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </section>
</body>
</html>
