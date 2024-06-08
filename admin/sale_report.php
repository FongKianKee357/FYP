<?php
// 连接到数据库
include '../components/connect.php';

// 查询订单表，按月份汇总销售额
$sql = "SELECT MONTH(placed_on) AS month , SUM(o.total_price) AS total_sales
        FROM orders o
        GROUP BY month
        ORDER BY month";

$result = $conn->query($sql);

// 将查询结果格式化为 Chart.js 所需的格式
$data = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = array(
        'month' => $row['month'],
        'total_sales' => $row['total_sales']
    );
}

// 关闭数据库连接
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monthly Sales Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="salesChart" width="800" height="400"></canvas>

    <script>
        // 使用 Chart.js 绘制图表
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesData = <?php echo json_encode($data); ?>;

        var orderMonths = salesData.map(function(item) {
            return item.month;
        });

        var sales = salesData.map(function(item) {
            return item.total_sales;
        });

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: orderMonths,
                datasets: [{
                    label: 'Monthly Sales',
                    data: sales,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
