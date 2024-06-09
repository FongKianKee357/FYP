<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    if ($select_user->rowCount() > 0) {
        $message[] = 'Email already exists!';
    } else {
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

        $insert_token = $conn->prepare("INSERT INTO `users` (email, verification_token, verification_expiry) VALUES (?, ?, ?)");
        $insert_token->execute([$email, $token_hash, $expiry]);

        require 'mailer.php';
        $mail->setFrom('lowrenxing2003@gmail.com');
        $mail->addAddress($email);
        $mail->Subject = 'Email Verification';
        $mail->Body = "Click <a href='http://localhost/FYP/verity_email.php?token=$token'>here</a> to verify your email and set your password.";


        try {
            $mail->send();
            $message[] = 'Verification email sent!';
        } catch (Exception $e) {
            $message[] = "Mailer error: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">
    <form action="" method="post">
        <h3>Register Now</h3>
        <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Register Now" class="btn" name="submit">
        <p>Already have an account?</p>
        <a href="user_login.php" class="option-btn">Login now</a>
    </form>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
<script src="js/script.js"></script>
<script>
   setTimeout(function() {
      var errorMessages = document.querySelectorAll('.message');
      errorMessages.forEach(function(errorMessage) {
         errorMessage.style.display = 'none';
      });
   }, 3000);
</script>
