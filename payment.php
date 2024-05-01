<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>TNG Payment</title>
    <style>
        body {
            background-image: url('images/contact-bg.jpg');
            background-size: cover;
        }

        .centered-image{
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 27%;
            border-radius: 15px;
        }

        .cont_btn .btn {
            display: flex;
            position: absolute;
            top: 93%;
            left: 50%;
            transform: translate(-50%, -50%);
            justify-content: center;
            align-items: center;
            height: 40px;
            width: 240px;
            background: #0864af;
            color: white;
        }

        .cont_btn .btn:hover {
            background: rgb(8, 178, 8);
        }

    </style>
</head>
<body>

    <img class="centered-image" src="images/TNG.jpg" alt="Centered Image">

    <div class="cont_btn">
        <a href="orders.php" class="btn">Click Here To Continue</a>
    </div>

</body>
</html>