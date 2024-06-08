<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = 'Incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <style>
      .forgot_font{
         font-size: 16px;
         color: var(--light-color);
         margin: 16px;
         margin-bottom: 0px;
         display: block;
      }

      .forgot_font:hover{
         color: var(--orange);
      }

      .font{
    
      }
   </style>
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" required placeholder="Enter Your Email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Enter Your Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" class="btn" name="submit">
      <p class="font">Don't Have An Account?</p>
      <a href="user_register.php" class="option-btn">register now</a>
      <a href="forgot_pass.php" class="forgot_font">Forgot Password</a>
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
   }, 2500);
</script>