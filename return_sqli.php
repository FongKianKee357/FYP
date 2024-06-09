<?php
$mysqli = new mysqli("localhost", "root", "", "shop_db");

if ($mysqli->connect_error) {
    die("Fail Connect: " . $mysqli->connect_error);
}

return $mysqli;
?>