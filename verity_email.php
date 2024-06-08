<?php
if (!isset($_GET["token"])) {
    die("Token not provided");
}

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

require __DIR__ . "/components/connect.php";

$sql = "SELECT * FROM users WHERE verification_token = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$token_hash]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user === false) {
    die("Token not found");
}

if (strtotime($user["verification_expiry"]) <= time()) {
    die("Token has expired");
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
    <?php include 'components/user_header.php'; ?>
    <h1>Create Password</h1>
    <form method="post" action="create_password.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label for="name">Username</label>
        <input type="text" id="name" name="name" required>
        <label for="password">New password</label>
        <input type="password" id="password" name="password" required>
        <label for="password_confirmation">Repeat password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <button type="submit">Create Password</button>
    </form>
</body>
</html>
