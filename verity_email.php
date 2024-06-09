<?php
if (!isset($_GET["token"])) {
    die("Token not provided");
}

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

require __DIR__ . "/components/connect.php";

$user_id = '';

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];
    $specialChars = '/!@#$%^&*()_+-=[]{}|;:,.<>?';

    if (strlen($password) < 6) {
        $message[] = 'Password must be at least 6 characters';
    } elseif (!preg_match('/[' . preg_quote($specialChars, '/') . ']/', $password)) {
        $message[] = 'Password must contain at least one special character';
    } elseif ($password !== $password_confirmation) {
        $message[] = 'Passwords must match';
    } else {
        $password_hash = sha1($password);

        $sql = "UPDATE users SET name = ?, password = ?, verification_token = NULL, verification_expiry = NULL WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $password_hash, $user["id"]]);

        $message[] = 'Password created successfully. You can now login.';

        header("Refresh: 2; URL=http://localhost/FYP/user_login.php");
    }
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

    <section class="form-container">
            <form method="post" action="">
                <h3>Create Password</h3>
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <input type="text" id="name" name="name" class="box" placeholder="Enter Your Name" required>
                <input type="password" id="password" name="password" class="box" placeholder="Enter Your Password" required>
                <input type="password" id="password_confirmation" name="password_confirmation" class="box" placeholder="Confirm Password" required>
                <button type="submit" class="btn">Create Password</button>
            </form>
    </section>

    <?php include 'components/footer.php'; ?>
</body>
</html>
<script>
   setTimeout(function() {
      var errorMessages = document.querySelectorAll('.message');
      errorMessages.forEach(function(errorMessage) {
         errorMessage.style.display = 'none';
      });
   }, 3000);
</script>
