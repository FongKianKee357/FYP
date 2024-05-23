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

   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if($old_pass == $empty_pass){
      $message[] = 'please enter old password!';
   }elseif($old_pass != $prev_pass){
      $message[] = 'old password not matched!';
   }elseif($new_pass != $cpass){
      $message[] = 'confirm password not matched!';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$cpass, $user_id]);
         $message[] = 'password updated successfully!';
      }else{
         $message[] = 'please enter a new password!';
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
   <title>register</title>
   <style>
      .profile_container{
   border: 2px solid black;
   display: flex;
   width: 900px;
   margin: 0 auto;
}

.sidebar{
   padding: 20px;
   padding-top: 82px;
   background-color: #fff;
   border-right: 2px solid #f0f0f0;
}

.sidebar a{
   display: block;
   padding: 10px;
   text-decoration: none;
   color: #333;
   font-size: 18px;
   border-bottom: 2px solid #f0f0f0;
}

.sidebar a:hover{
   background-color: #f0f0f0;
   border-radius: 5px;
}

.profile_container form{
   background-color: white;
   padding: 25px;
   box-shadow: var(--box-shadow);
   text-align: center;
   margin:0 auto;
   max-width: 100%;
}

.form-container-f{
   background: url(./images/login-img.png) ;
   background-size: cover;
   background-position: center;
   max-width: 100%;
   padding: 65px;
}

.form-container-f form h3{
   font-size: 34px;
   text-transform: uppercase;
   color: black;
}

.form-container-f form .box{
   margin:10px 0;
   background-color: var(--light-bg);
   padding:13px;
   font-size: 18px;
   color:var(--black);  
   width: 100%;
   border-radius: 5px;
}
   </style>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
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
               <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" value="<?= $fetch_profile["name"]; ?>">
               <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
               <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               <input type="password" name="new_pass" placeholder="enter your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               <input type="password" name="cpass" placeholder="confirm your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               <input type="submit" value="update now" class="btn" name="submit">
            </form>
         </div>
         
         <div id="address" class="section" style="display: none;">
            <form action="" method="post">
               <h3>update address</h3>
               <input type="text" name="address1" placeholder="Enter your address 1" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')" >
               <input type="text" name="address2" placeholder="Enter your address 2" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')" >
               <input type="text" name="address3" placeholder="Enter your address 3" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')" >
               <input type="submit" value="update now" class="btn" name="submit">
            </form>
         </div>
      </div>
   </div>
</div>

<?php include 'components/footer.php'; ?>

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
</script>

</body>
</html>