<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   function hasSpecialCharacter($password) {
      $specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';
      return preg_match('/[' . preg_quote($specialChars, '/') . ']/', $password);
   }

   $valid = true;

   if($select_user->rowCount() > 0){
      $message[] = 'email already exists!';
      $valid = false; 
   }

   if($pass != $cpass) {
      $message[] = 'Confirm password not matched!';
      $valid = false; 
   } elseif(strlen($_POST['pass']) < 6) {
      $message[] = 'Password is too short (minimum is 6 characters)';
      $valid = false; 
   } elseif(!hasSpecialCharacter($_POST['pass'])) {
      $message[] = 'Password must contain at least one special character';
      $valid = false; 
   }

   if($valid != false) {
      $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
      $insert_user->execute([$name, $email, $cpass]);
      $message[] = 'registered successfully, login now please!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="Enter your username" maxlength="20"  class="box">
      <input type="email" name="email" required placeholder="Enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Enter your password" maxlength="50" minlength="6" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Confirm your password" maxlength="50" minlength="6" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" class="btn" name="submit">
      <p>already have an account?</p>
      <a href="user_login.php" class="option-btn">login now</a>
   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
