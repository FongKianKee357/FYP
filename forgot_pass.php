<?php

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
                echo "Message sent, please check your inbox.";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            }
        } else {
            echo "No user found with that email.";
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: {$mysqli->error}";
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
    <style>
        /* 全局样式 */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        /* 表单容器 */
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 20px;
        }

        /* 表单元素 */
        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"],
        button[type="submit"] {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="email"] {
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="forgot_pass.php" method="POST">
            <h1>Forget Password</h1>
            <input type="email" name="email" placeholder="Enter your email">
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
