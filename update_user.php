<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   
   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);
   
   $phoneNum = $_POST['phoneNum'];
   $phoneNum = filter_var($phoneNum, FILTER_SANITIZE_STRING);

   $update_phoneNum = $conn->prepare("UPDATE `users` SET phoneNum = ? WHERE id = ?");
   $update_phoneNum->execute([$phoneNum, $user_id]);

   if (!empty($_POST['old_pass']) || !empty($_POST['new_pass']) || !empty($_POST['cpass'])) {
      $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
      $prev_pass = $_POST['prev_pass'];
      $old_pass = sha1($_POST['old_pass']);
      $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
      $new_pass = sha1($_POST['new_pass']);
      $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
      $cpass = sha1($_POST['cpass']);
      $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

      if ($old_pass == $empty_pass) {
          $message[] = 'Please enter old password!';
      } elseif ($old_pass != $prev_pass) {
          $message[] = 'Old password not matched!';
      } elseif ($new_pass != $cpass) {
          $message[] = 'Confirm password not matched!';
      } else {
          if ($new_pass != $empty_pass) {
              $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
              $update_admin_pass->execute([$cpass, $user_id]);
              $message[] = 'Password updated successfully!';
          } else {
              $message[] = 'Please enter a new password!';
          }
      }
  }
      $message[] = 'Profile updated successfully!';
}

if (isset($_POST['submit_a'])) {
   $address1 = $_POST['address1'];
   $address1 = filter_var($address1, FILTER_SANITIZE_STRING);
   $address2 = $_POST['address2'];
   $address2 = filter_var($address2, FILTER_SANITIZE_STRING);
   $address3 = $_POST['address3'];
   $address3 = filter_var($address3, FILTER_SANITIZE_STRING);

   $update_address = $conn->prepare("UPDATE `users` SET address1 = ?, address2 = ?, address3 = ? WHERE id = ?");
   
   if ($update_address->execute([$address1, $address2, $address3, $user_id])) {
      $message[] = "Address updated successfully!";
   } else {
      $message[] = "Error updating address: ";
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="./css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>
<div class="form-container-f">
   <div class="profile_container">
      <div class=sidebar>
         <a href="#profile">Personal</a>
         <a href="#address">Address</a>
      </div>
         
      <div class="contents">
         <div id="profile" class="section" style="display: block;">
            <form action="" method="post">
               <h3>update personal</h3>
               <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
               <input type="text" name="name" required placeholder="Enter your Username" maxlength="20"  class="box" value="<?= $fetch_profile["name"]; ?>">
               <input type="email" name="email" required placeholder="Enter your Email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
               <input type="num" name="phoneNum" required placeholder="Enter your Phone Number" maxlength="15"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["phoneNum"]; ?>">
               <input type="password" name="old_pass" placeholder="Enter your Old Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               <input type="password" name="new_pass" placeholder="Enter your New Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               <input type="password" name="cpass" placeholder="Confirm your New Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               <input type="submit" value="update now" class="btn" name="submit">
            </form>
         </div>
         
         <div id="address" class="section" style="display: none;">
            <form action="" method="post">
               <h3>update address</h3>
               <input type="text" name="address1" placeholder="Enter your Address 1" maxlength="100" class="box" value="<?= $fetch_profile["address1"];?>" >
               <input type="text" name="address2" placeholder="Enter your Address 2" maxlength="100" class="box" value="<?= $fetch_profile["address2"];?>">
               <input type="text" name="address3" placeholder="Enter your Address 3" maxlength="100" class="box" value="<?= $fetch_profile["address3"];?>">
               <input type="submit" value="update now" class="btn" name="submit_a">
            </form>
         </div>
      </div>
   </div>
</div>

<?php include 'components/footer.php'; ?>

</body>
</html>
<script src="js/script.js"></script>
<script>
    function showSection(sectionId) {
        document.querySelectorAll('.section').forEach(section => {
            section.style.display = 'none';
        });
        document.getElementById(sectionId).style.display = 'block';
    }

    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            showSection(this.getAttribute('href').substring(1)); 
        });
    });

    setTimeout(function() {
      var errorMessages = document.querySelectorAll('.message');
      errorMessages.forEach(function(errorMessage) {
         errorMessage.style.display = 'none';
      });
   }, 2500);
</script>