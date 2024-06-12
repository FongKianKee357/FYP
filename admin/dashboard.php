<?php
// 连接到数据库
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}

// 查询订单表，按月份汇总销售额
$sql = "SELECT MONTH(placed_on) AS month, SUM(o.total_price) AS total_sales
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

// 获取已登录管理员的个人资料数据
$select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
$select_profile->execute([$admin_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #salesChart {
            width: 800px;
            height: 400px;
            background-color: white;
        }

        h2{
            color: black;
            font-size: 4rem;
            text-transform: uppercase;
        }

        .content {
            flex-grow: 1;
            padding: 0px;
        }
        
        .p_p {
            font-size: 2em; /* 字體變大 */
            font-weight: bold; /* 字體加粗 */
            color: purple; /* 字體顏色變為紫色 */
            text-shadow: 2px 2px 5px white; /* 添加白色陰影 */
        }

        .salereport {
            font-size: 3em; /* 讓 salereport 標題更大 */
            font-weight: bold; /* 字體加粗 */
            color: purple; /* 字體顏色變為紫色 */
            text-shadow: 2px 2px 5px white; /* 添加白色陰影 */
        }

        .welcome{
            text-align: left;
            padding: 0px 1rem;
            font-size: 28px;
            color: #90cbf3;
        }
        
        img{
            height: 150px;
            width: 150px;
        }

        .logo{
            text-align: center;
            height: 150px;
        }
    
    </style>
</head>
<body>
    <div class="main-container">
        <aside class="sidebar">
            <ul class="menu">
                <div class="logo"><img src="../images/logo.png" alt="LOGO"></div>
                <li><a href="./products.php">Products</a></li>
                <li><a href="./placed_orders.php">Orders</a></li>
                <li><a href="./admin_accounts.php">Admins</a></li>
                <li><a href="./users_accounts.php">Users</a></li>
                <li><a href="./messages.php">Messages</a></li>
                <!-- 添加指向销售报告的链接 -->
                <li><a href="#salesReport">Sales Report</a></li>
            </ul>
        </aside>
        <div class="content">
            <button class="toggle-sidebar-btn" onclick="toggleSidebar()">☰</button>
            <header class="header">
                <div class="flex">
                    <nav class="navbar">
                        <a href="../home.php" class="logo">Boutique Handcraft Model House</a>
                    </nav>
                    <div class="icons">
                        <div id="menu-btn" class="fas fa-bars"></div>
                        <div id="user-btn" class="fas fa-user"></div>
                    </div>
                    <div class="profile">
                        <p class="p_p"><?= $fetch_profile['name']; ?></p>
                        <a href="../admin/update_profile.php" class="btn">update profile</a>
                        <div class="flex-btn">
                            <a href="../admin/register_admin.php" class="option-btn">register</a>
                            <a href="../admin/admin_login.php" class="option-btn">login</a>
                        </div>
                        <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a>
                    </div>
                </div>
            </header>
            <section class="dashboard">
                <h1 class="heading">Dashboard</h1>
                <div class="box-container">
                    <div class="box">
                        <h3>Admin</h3>
                        <p class="p_p"><?= htmlspecialchars($fetch_profile['name']); ?></p>
                        <a href="update_profile.php" class="btn">Update Profile</a>
                    </div>
                </div>
            </section>
            <br>
            <section id="salereport" class="chart-container">
                <h2>Sale Report</h2>
                    <div class="box-container">
                        <p class="p_p">This report shows the monthly sales data.</p>
                    </div>
                <canvas id="salesChart"></canvas>
            </section>
        </div>
    </div>

    <script src="../js/admin_script.js"></script>
    <script>
        function toggleProfile() {
            document.querySelector('.profile').classList.toggle('active');
        }
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        }

        // 使用 Chart.js 绘制图表
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesData = <?php echo json_encode($data); ?>;

        var orderMonths = salesData.map(function(item) {
            return item.month;
        });

        var sales = salesData.map(function(item) {
            return item.total_sales;
        });

        // 定义一组深色系颜色
        var colors = [
            'rgba(75, 0, 130, 0.8)',  // Indigo
            'rgba(139, 0, 0, 0.8)',   // Dark Red
            'rgba(0, 100, 0, 0.8)',   // Dark Green
            'rgba(0, 0, 139, 0.8)',   // Dark Blue
            'rgba(85, 107, 47, 0.8)', // Dark Olive Green
            'rgba(128, 0, 128, 0.8)', // Purple
            'rgba(139, 69, 19, 0.8)', // Saddle Brown
            'rgba(47, 79, 79, 0.8)',  // Dark Slate Gray
            'rgba(0, 139, 139, 0.8)', // Dark Cyan
            'rgba(25, 25, 112, 0.8)', // Midnight Blue
            'rgba(128, 128, 0, 0.8)', // Olive
            'rgba(72, 61, 139, 0.8)'  // Dark Slate Blue
        ];

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: orderMonths,
                datasets: [{
                    label: 'Monthly Sales',
                    data: sales,
                    backgroundColor: colors,
                    borderColor: colors,
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
    </script>
</body>
</html>
