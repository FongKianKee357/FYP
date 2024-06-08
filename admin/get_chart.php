<?php
include 'components/connect.php';
session_start();

$response = [];

if(isset($_GET['type'])) {
    $type = $_GET['type'];

    if($type == 'orders' && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = $conn->prepare("SELECT placed_on, COUNT(*) as order_count FROM `orders` WHERE user_id = ? GROUP BY placed_on ORDER BY placed_on");
        $query->execute([$user_id]);
        $orders = $query->fetchAll(PDO::FETCH_ASSOC);
        $response = $orders;
    } elseif($type == 'products') {
        $query = $conn->prepare("SELECT products.name, SUM(orders.total_products) as total_sales 
                                    FROM orders 
                                    JOIN products ON orders.product_id = products.id 
                                    GROUP BY products.name");
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        $response = $products;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>