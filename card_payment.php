<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}else{
  $user_id = '';
  header('location:user_login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Payment</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Lato:400,100,300,700,900);
        @import url(https://fonts.googleapis.com/css?family=Source+Code+Pro:400,200,300,500,600,700,900);
.container {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  flex-direction: column;
}

* {
  box-sizing: border-box;
}

html {
  background-image: url('images/contact-bg.jpg');
  font-family: "Lato", sans-serif;
}

.price h1 {
  font-weight: 600;
  color: #0864af;
  letter-spacing: 2px;
}

.card {
  margin-top: 30px;
  margin-bottom: 30px;
  width: 520px;
  height: 400px;
}
.card .row {
  height: 20%;
  width: 100%;
}
.card .row:last-child {
  border: none;
}
.card .credit {
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}
.card .details {
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
}
.card .credit {
  background-color: white;
  box-shadow: 10px 10px rgba(0, 0, 0, 0.15);
}
.card .cardholder, .card .number, .card .details {
  background-color: white;
  box-shadow: 10px 10px rgba(0, 0, 0, 0.15);
}

.credit .left, .credit .right {
  position: relative;
  top: 50%;
  transform: translateY(-50%);
}
.credit .left {
  float: left;
  margin-left: 50px;
}
.credit .left label {
  margin-left: 10px;
  font-size: 1rem;
  cursor: pointer;
  font-weight: 700;
  letter-spacing: 0.5px;
  color: #868686cc;
}
.credit .left input[type=radio] {
  visibility: hidden;
}
.credit .left .radio {
  position: absolute;
  top: -2px;
  left: -20px;
  border: 3px solid #414365;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background-color: #292B52;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.credit .left .radio::before {
  position: absolute;
  content: "";
  border-radius: 50%;
  top: 5px;
  left: 5px;
  width: 9px;
  height: 9px;
  background-color: transparent;
  transition: background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.credit .right {
  float: right;
  margin-right: 30px;
}
.credit .right img {
  width: 42px;
  height: 30px;
  margin-left: 10px;
}

input[type=radio]:checked ~ .radio {
  border: 3px solid #90E1E3;
  background-color: #18C2C0;
}
input[type=radio]:checked ~ .radio::before {
  background-color: #fff;
}

.cardholder .info, .number .info {
  position: relative;
  top: 50%;
  transform: translateY(-50%);
  margin-left: 40px;
}
.cardholder .info label, .number .info label {
  display: inline-block;
  letter-spacing: 0.5px;
  color: #868686cc;
  width: 100px;
}
.cardholder .info input, .number .info input {
  display: inline-block;
  max-width: 300px;
  width: 300px;
  background-color: transparent;
  font-family: "Source Code Pro";
  border: none;
  outline: none;
  margin-left: 50px;
}
.cardholder .info input::-moz-placeholder, .number .info input::-moz-placeholder {
  font-family: "Source Code Pro";
  color: #444880;
}
.cardholder .info input:-ms-input-placeholder, .number .info input:-ms-input-placeholder {
  font-family: "Source Code Pro";
  color: #444880;
}
.cardholder .info input::placeholder, .number .info input::placeholder {
  font-family: "Source Code Pro";
  color: #444880;
}

#cardnumber::-moz-placeholder {
  letter-spacing: 2px;
}

#cardnumber:-ms-input-placeholder {
  letter-spacing: 2px;
}

#cardnumber, #cardnumber::placeholder {
  letter-spacing: 2px;
}

.details .left, .details .right {
  position: relative;
  top: 50%;
  transform: translateY(-50%);
}
.details .left {
  float: left;
  padding-left: 40px;
  width: 50%;
}
.details .left label {
  letter-spacing: 0.5px;
  color: #868686cc;
  width: 100px;
  margin-right: 20px;
}
.details .left select {
  font-family: "Source Code Pro";
  cursor: pointer;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  background: transparent;
  border: none;
  outline: none;
  color: #444880;
}
.details .left span {
  font-family: "Source Code Pro";
  color: #444880;
  margin: 0 2px;
}
.details .right {
  float: right;
  width: 50%;
}
.details .right label {
  margin-right: 20px;
  color: #868686cc;
}
.details .right input {
  text-align: center;
  width: 50px;
  font-family: "Source Code Pro";
  cursor: pointer;
  background: transparent;
  border: none;
  outline: none;
}
.details .right input::-moz-placeholder {
  font-family: "Source Code Pro";
  color: #444880;
}
.details .right input:-ms-input-placeholder {
  font-family: "Source Code Pro";
  color: #444880;
}
.details .right input::placeholder {
  font-family: "Source Code Pro";
  color: #444880;
}
.details .right span {
  text-align: center;
  display: inline-block;
  font-family: "Source Code Pro";
  cursor: pointer;
  margin-left: 50px;
  color: #18C2C0;
  width: 24px;
  height: 24px;
  border: 2px solid #18C2C0;
  border-radius: 50%;
}

.button button {
  font-size: 1.2rem;
  font-weight: 400;
  letter-spacing: 1px;
  width: 520px;
  background-color: #18C2C0;
  border: none;
  color: #fff;
  padding: 18px;
  border-radius: 5px;
  outline: none;
  transition: background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.button button:hover {
  background-color: #15aeac;
}
.button button:active {
  background-color: #139b99;
}
.button button i {
  font-size: 1.2rem;
  margin-right: 5px;
}
    </style>
</head>
<body>

<div class="container">

<?php

         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);

         $total_price = 0;

         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
              $total_price = $fetch_orders['total_price'];
      }
      }
   ?>

<div class="price">
      <h1>Total Price : <span>RM<?= $total_price; ?></span></h1>
   </div>
    <div class="card__container">
        <div class="card">
            <div class="row credit">
                <div class="left">
                    <label for="cd">Debit/ Credit Card</label>
                </div>
                <div class="right">
                    <img src="./images/visa.png" alt="visa" style="border-radius: 5px"/>
                    <img src="./images/mastercard.png" alt="mastercard" style="border-radius: 5px;"/>
                </div>
            </div>
            <div class="row cardholder">
                <div class="info">
                    <label for="cardholdername">Name</label>
                    <input placeholder="Enter Your Name" id="cardholdername" type="text" />
                </div>
            </div>
            <div class="row number">
                <div class="info">
                    <label for="cardnumber">Card number</label>
                    <input id="cardnumber" type="text" pattern="[0-9]{16,19}" maxlength="19" placeholder="0000-0000-0000-0000" />
                </div>
            </div>
            <div class="row details">
                <div class="left">
                    <label for="expiry-date">Expiry</label>
                    <select id="expiry-date">
                        <option>MM</option>
                        <option value="1">01</option>
                        <option value="2">02</option>
                        <option value="3">03</option>
                        <option value="4">04</option>
                        <option value="5">05</option>
                        <option value="6">06</option>
                        <option value="7">07</option>
                        <option value="8">08</option>
                        <option value="9">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <span>/</span>
                    <select id="expiry-date">
                        <option>YYYY</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                    </select>
                </div>
                <div class="right">
                    <label for="cvv">CVC/CVV</label>
                    <input type="text" maxlength="4" placeholder="123" />
                </div>
            </div>
        </div>
    </div>
    <div class="button">
        <button type="submit" onclick="location.href='orders.php'"><i class="ion-locked"></i> Confirm and Pay</button>

    </div>
</div>
</body>
</html>