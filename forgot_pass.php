<?php

require __DIR__ . "/components/connect.php";
$user_id = '';

// 如果请求方法为POST且email字段被设置
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = $_POST["email"];
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);
    $mysqli = require __DIR__ . "/return_sqli.php";
    $sql = "UPDATE users
            SET Reset_passToken = ?,
                Reset_passExpires = ?
            WHERE email = ?";

    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sss", $token_hash, $expiry, $email);
        $stmt->execute();

        if ($mysqli->affected_rows) {
            $mail = require __DIR__ . "/mailer.php";

            $mail->setFrom("lowrenxing2003@gmail.com");
            $mail->addAddress($email);
            $mail->Subject = "Password Reset";
            $mail->Body = <<<END
            Click <a href="http://localhost/FYP/reset_pass.php?token=$token">here</a> 
            to reset your password.
            END;

            try {
                $mail->send();
                $message[] = 'Message sent, please check your inbox.';
            } catch (Exception $e) {
                $message[] = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            }
        } else {
            $message[] = 'No user found with that email.';
        }

        $stmt->close();
    } else {
        $message[] = "Error preparing statement: {$mysqli->error}";
    }

    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <section class="form-container">
        <form action="forgot_pass.php" method="POST">
            <h3>Forgot Password</h3>
            <input type="email" name="email" placeholder="Enter your email" class="box">
            <button type="submit" class="option-btn">Reset Password</button>
        </form>
    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
    <script>
        setTimeout(function() {
            var errorMessages = document.querySelectorAll('.message');
            errorMessages.forEach(function(errorMessage) {
                errorMessage.style.display = 'none';
            });
        }, 3000);
</script>
</body>
</html>
