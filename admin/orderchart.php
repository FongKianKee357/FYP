<?php

include '../components/connect.php';

session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php'); // Redirect to login page if not logged in
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Chart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">
    <h1 class="heading">Products Data Chart</h1>
    <canvas id="productsChart" width="400" height="200"></canvas>
</section>

<?php include '../components/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('get_products.php')
            .then(response => response.json())
            .then(data => {
                console.log(data); // For debugging: check what data is received

                if (data.length === 0) {
                    console.log('No products found or admin not logged in');
                    return;
                }

                // Process the data to format it for Chart.js
                const labels = data.map(product => product.name); // Product names
                const prices = data.map(product => parseFloat(product.price)); // Product prices

                // Create the chart
                const ctx = document.getElementById('productsChart').getContext('2d');
                const productsChart = new Chart(ctx, {
                    type: 'bar', // You can change this to 'line', 'pie', etc.
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Product Prices (RM)',
                            data: prices,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching product data:', error));
    });
</script>

<script src="../js/admin_script.js"></script>

</body>
</html>
