<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
   exit;
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'No. '. $_POST['flat'] .', '. $_POST['street'].', '. $_POST['pin_code'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'order placed successfully!';
   }else{
      $message[] = 'your cart is empty';
   }

   if($method == 'TNG eWallet'){
      header('location:payment.php');
   }else if($method == 'Pay with card'){
      header('location:card_payment.php');
   }else{
      header('location:orders.php');
   }
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>your orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items = [];  // Initialize cart_items as an array
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            }
            $total_products = implode($cart_items);  // Move this line out of the while loop
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= htmlspecialchars($total_products); ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
         <div class="grand-total">Grand Total : <span>RM<?= $grand_total; ?></span></div>
      </div>

      <h3>place your orders</h3>

      <form id="checkoutForm" action="" method="post">
        <div class="flex">
         <div class="inputBox">
               <span>Your Name :</span>
               <?php
                  $username = '';
                  if($user_id != ''){
                        $stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
                        $stmt->execute([$user_id]);
                        if($stmt->rowCount() > 0){
                           $row = $stmt->fetch(PDO::FETCH_ASSOC);
                           $username = $row['name'];
                        }
                  }
               ?>
               <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" value="<?= htmlspecialchars($username); ?>" required>
            </div>

            <div class="inputBox">
               <span>Your Contact Number :</span>
               <?php 
                  $phone = '';
                  if($user_id != ''){
                        $stmt = $conn->prepare("SELECT phonenum FROM users WHERE id = ?");
                        $stmt->execute([$user_id]);
                        if($stmt->rowCount() > 0){
                           $row = $stmt->fetch(PDO::FETCH_ASSOC);
                           $phone = $row['phonenum'];
                        }
                  }
               ?>
               <input type="number" name="number" placeholder="Enter your contact number" class="box" min="0" max="9999999999" value="<?= htmlspecialchars($phone); ?>" required maxlength="10">
            </div>

            <div class="inputBox">
               <span>Your Email :</span>
               <?php
               // 从数据库中获取用户的电子邮件
                  $email = '';
                  if ($user_id != '') {
                     $stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
                     $stmt->execute([$user_id]);
                     if ($stmt->rowCount() > 0) {
                           $row = $stmt->fetch(PDO::FETCH_ASSOC);
                           $email = $row['email'];
                     }
                  }
               ?>
               <input type="email" name="email" placeholder="Enter your email" value="<?= htmlspecialchars($email); ?>" class="box" maxlength="50" required>
         </div>

            <div class="inputBox">
                <span>Payment Method :</span>
                <select name="method" class="box" required>
                <option value="Cash on delivery">Cash on delivery</option>
                <option value="TNG eWallet">TNG eWallet</option>
                <option value="Pay with card">Pay with card</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Address :</span>
                <select name="flat" class="box" required>
                <option value="" disabled selected>Select Address</option>
                <?php

                // 从数据库中选择地址
                $sql = "SELECT address1, address2, address3 FROM users Where id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$user_id]);

                // 检查是否有结果
                if ($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if (!empty($row["address1"])) {
                            echo '<option value="' . htmlspecialchars($row["address1"]) . '">' . htmlspecialchars($row["address1"]) . '</option>';
                        }
                        if (!empty($row["address2"])) {
                            echo '<option value="' . htmlspecialchars($row["address2"]) . '">' . htmlspecialchars($row["address2"]) . '</option>';
                        }
                        if (!empty($row["address3"])) {
                            echo '<option value="' . htmlspecialchars($row["address3"]) . '">' . htmlspecialchars($row["address3"]) . '</option>';
                        }
                    }
                } else {
                    echo '<option value="" disabled>No addresses found</option>';
                }

                ?>
                </select>
            </div>
        </div>

        <input type="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value="place order">
      </form>
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
