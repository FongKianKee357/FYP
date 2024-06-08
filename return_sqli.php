<?php
$mysqli = new mysqli("localhost", "root", "", "shop_db");

if ($mysqli->connect_error) {
    die("连接失败: " . $mysqli->connect_error);
}

return $mysqli;
?>