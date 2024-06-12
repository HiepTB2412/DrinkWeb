<?php
require_once('database/dbhelper.php');
// Mảng để lưu tổng tiền của mỗi loại mặt hàng
$totalAmounts = array(
    'tra_sua' => 0,
    'coffe' => 0,
    'sinh_to' => 0,
    'do_an_vat' => 0
);

// Truy vấn tổng tiền cho từng mặt hàng
$queries = [
    'tra_sua' => "SELECT SUM(order_details.num * order_details.price) AS total
    FROM order_details
    JOIN product ON order_details.product_id = product.id
    WHERE product.id_category = 1;
    ",
    'coffe' => "SELECT SUM(order_details.num * order_details.price) AS total
    FROM order_details
    JOIN product ON order_details.product_id = product.id
    WHERE product.id_category = 2;
    ",
    'sinh_to' => "SELECT SUM(order_details.num * order_details.price) AS total
    FROM order_details
    JOIN product ON order_details.product_id = product.id
    WHERE product.id_category = 3;
    ",
    'do_an_vat' => "SELECT SUM(order_details.num * order_details.price) AS total
    FROM order_details
    JOIN product ON order_details.product_id = product.id
    WHERE product.id_category = 4;
    "
];
$tongsl=[
    'tra_sua' => "SELECT SUM(order_detail.num) AS total
    FROM order_details
    JOIN product ON order_details.product_id = product.id
    WHERE product.id_category = 1;
    ",
    'coffe' => "SELECT SUM(order_detail.num) AS total
    FROM order_details
    JOIN product ON order_details.product_id = product.id
    WHERE product.id_category = 2;
    ",
    'sinh_to' => "SELECT SUM(order_detail.num) AS total
    FROM order_details
    JOIN product ON order_details.product_id = product.id
    WHERE product.id_category = 3;
    ",
    'do_an_vat' => "SELECT SUM(order_details.num * order_details.price) AS total
    FROM order_details
    JOIN product ON order_details.product_id = product.id
    WHERE product.id_category = 4;
    "  
];
$topProductsQuery = "
    SELECT product.title, category.name AS category_name, SUM(order_details.num) AS total_quantity, SUM(order_details.num * order_details.price) AS total_revenue
    FROM order_details
    JOIN product ON order_details.product_id = product.id
    JOIN category ON product.id_category = category.id
    GROUP BY product.id
    ORDER BY total_quantity DESC
    LIMIT 3;
";
$topProductsResult = executeResult($topProductsQuery);



// Khởi tạo mảng để lưu trữ top 3 sản phẩm bán chạy nhất
$topProducts = array();

// Kiểm tra xem kết quả truy vấn có dữ liệu hay không
if ($topProductsResult && !empty($topProductsResult)) {
    // Duyệt qua từng dòng kết quả và thêm vào mảng topProducts
    foreach ($topProductsResult as $product) {
        $productInfo = array(
            'title' => $product['title'],
            'category_name' => $product['category_name'],
            'total_quantity' => $product['total_quantity'],
            'total_revenue' => $product['total_revenue']
        );
        $topProducts[] = $productInfo;
    }
}
$totalProductQuery="SELECT SUM(order_details.num) AS total_quantity FROM order_details";
$result = executeSingleResult($totalProductQuery);

// Kiểm tra nếu có kết quả
if ($result) {
    // Lấy tổng số lượng sản phẩm đã bán từ kết quả
    $totalQuantity = $result['total_quantity'];
} else {
    // Nếu không có kết quả, gán tổng số lượng sản phẩm đã bán là 0
    $totalQuantity = 0;
}

// Hiển thị thông tin top 3 sản phẩm bán chạy nhất

foreach ($queries as $key => $query) {
    $result = executeResult($query); // Thay đổi dòng này
    if ($result && !empty($result)) {
        $totalAmounts[$key] = $result[0]['total']; // Chỉ lấy giá trị đầu tiên
    } else {
        $totalAmounts[$key] = 0; // Gán giá trị 0 nếu không có kết quả hoặc kết quả rỗng
    }
}

// Kiểm tra và gán giá trị 0 cho các mặt hàng không có giá trị
foreach ($totalAmounts as $key => $total) {
    if (!isset($total)) {
        $totalAmounts[$key] = 0;
    }
}
$totalRevenue = array_sum($totalAmounts);
// In ra tổng tiền của mỗi mặt hàng
$percentages = [];
foreach ($totalAmounts as $key => $total) {
    $percentage = ($total / $totalRevenue) * 100;
    $percentages[$key] = $percentage;
}

?>
<?php
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
?>
<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box
        }
        .user {
            position: relative;
            width: 50px;
            height: 50px;
        }

        .user img {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            object-fit: cover
        }

        .topbar {
            position: fixed;
            background: #fff;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.08);
            width: 100%;
            height: 60px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 2fr 10fr 0.4fr 1fr;
            align-items: center;
            z-index: 1;
        }

        .search {
            position: relative;
            width: 60%;
            justify-self: center;
        }

        .search input{
            width: 100%;
            height: 40px;
            padding: 0 40px;
            font-size: 16px;
            outline: none;
            border: none;
            border-radius: 10px;
            background: #f5f5f5;
        }

        .search i {
            position: absolute;
            right: 15px;
            top: 15px;
            cursor: pointer;
        }

        .sidebar {
            position: fixed;
            top: 60px;
            width: 260px;
            height: calc(100% - 60px);
            background: #299B63;
            overflow-x: hidden;
        }

        .sidebar ul {
            margin-top: 20px;
        }

        .sidebar ul li {
            width: 100%;
            list-style: none;
        }

        .sidebar ul li a {
            width: 100%;
            text-decoration: none;
            color: #fff;
            height: 60px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #267f56; /* Darker green for hover */
        }

        .sidebar ul li a i {
            min-width: 60px;
            font-size: 24px;
            text-align: center;
        }

        .sidebar ul li a.active {
            background-color: #267f56; /* Active background color: red */
            color: #fff; /* Ensure text color remains white */
        }   

        .main {
            position: absolute;
            top: 60px;
            width: calc(100% - 260px);
            left: 260px;
            min-height: calc(100vh - 60px);
            background: #f5f5f5;
        }

        .cards {
            width: 100%;
            padding: 35px 20px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 20px;
        }

        .cards .card {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 7px 25px 0 rgba(0,0,0,0.08)
        }

        .number {
            font-size: 35px;
            font-weight: 500;
            color: #299B63;
        }

        .card-name {
            color: #888;
            font-weight: 600;
        }

        .icon-box i {
            font-size: 45px;
            color: #299B63;
        }

        .charts {
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-gap: 20px;
            width: 100%;
            padding: 20px;
            padding-top: 0;
        }

        .chart {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 7 25px rgba(0,0,0,0.08);
            width: 100%;
        }

        .chart h2 {
            margin-bottom: 5px;
            font-size: 20px;
            color: #666;
            text-align: center;
        }

        .test{
            padding: 20px;
        }

        .topbar a {
            text-align: center;
            padding: 10px;
            background-color: #299b63;
            border: none;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
        }

        .topbar a:hover {
            background-color: #267f56;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div class="logo">
                <h2>Drink.</h2>
            </div>
            <div class="search">
                <input type="text" id="search" placeholder="Search here">
                <label for="search"><i class="fas fa-search"></i></label>
            </div>
            <div class="user">
                <img src="https://static.vecteezy.com/system/resources/previews/021/548/095/non_2x/default-profile-picture-avatar-user-avatar-icon-person-icon-head-icon-profile-picture-icons-default-anonymous-user-male-and-female-businessman-photo-placeholder-social-network-avatar-portrait-free-vector.jpg" alt="">
            </div>
            <a href="pdf.php" target="_blank">Xuất PDF</a>
        </div>
        

        <div class="sidebar">
            <ul>
                <li>
                    <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-chart-line"></i>
                        <div>Thống kê</div>
                    </a>
                </li>
                <li>
                    <a href="category/index.php" class="<?php echo ($current_page == 'category/index.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-bars-progress"></i>
                        <div>Quản lý danh mục</div>
                    </a>
                </li>
                <li>
                    <a href="product/index.php" class="<?php echo ($current_page == 'product/index.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-mug-saucer"></i>
                        <div>Quản lý sản phẩm</div>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <div>Quản lý đơn hàng</div>
                    </a>
                </li>
                <li>
                    <a href="customer.php" class="<?php echo ($current_page == 'customer.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-person"></i>
                        <div>Quản lý khách hàng</div>
                    </a>
                </li>
                <li>
                    <a href="revenue.php" class="<?php echo ($current_page == 'revenue.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-chart-simple"></i>
                        <div>Biểu đồ</div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main">
            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?php echo number_format($totalRevenue, 0, ',', '.'); ?> VND</div>
                        <div class="card-name">Tổng tiền</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="number">
                            <?php
                                $sql = "SELECT COUNT(*) AS total_products FROM product;";
                                $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                echo '<span>' . $row['total_products'] . '</span>';
                                mysqli_close($conn);
                            ?>
                        </div>
                        <div class="card-name">Tổng sản phẩm</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-mug-hot"></i>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="number">
                            <?php
                                $sql = "SELECT COUNT(*) AS total_orders FROM order_details;";
                                $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                echo '<span>' . $row['total_orders'] . '</span>';
                                mysqli_close($conn);
                            ?>
                        </div>
                        <div class="card-name">Tổng số đơn hàng</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-cart-shopping"></i>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="number">
                            <?php
                                $sql = "SELECT COUNT(*) AS total_users FROM user;";
                                $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                echo '<span>' . $row['total_users'] . '</span>';
                                mysqli_close($conn);
                            ?>
                        </div>
                        <div class="card-name">Tổng số khách hàng</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="charts">
                <div class="chart">
                    <h2><?php echo "Doanh thu theo từng sản phẩm - " . date("F"); ?></h2>
                    <canvas id="revenue-product"></canvas>
                    <h4 class="test"></h4>
                    <h2>Doanh thu theo 12 tháng</h2>
                    <canvas id="lineChart"></canvas>
                    <h4 class="test"></h4>
                    <h2>Top 3 người mua hàng nhiều nhất</h2>
                    <canvas id="lineUser"></canvas>
                </div>
                <div class="chart" id="doughnut-chart">
                    <h2><?php echo "KPI - " . date("d") . " " . date("F"); ?></h2>
                    <canvas id="doughnut-kpi"></canvas>
                    <h4 class="test"></h4>
                    <h2><?php echo "Doanh thu theo danh mục - " . date("F"); ?></h2>
                    <canvas id="doughnut"></canvas>
                    <h4 class="test"></h4>
                    <h2><?php echo "Doanh thu theo năm"; ?></h2>
                    <canvas id="doughnut-year"></canvas>
                    <h4 class="test"></h4>
                </div>
            </div>
        </div>
    </div>

<script>
    // Hàm để lấy dữ liệu doanh thu hàng tháng qua AJAX
    function fetchMonthlyRevenue() {
        // Thực hiện một yêu cầu AJAX đến script PHP
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_monthly_revenue.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr);
                // Parse dữ liệu JSON nhận được thành một mảng
                var revenueData = JSON.parse(xhr.responseText);
                updateChart(revenueData);
            }
        };
        xhr.send();
    }

    // Hàm để cập nhật biểu đồ với dữ liệu đã lấy được
    function updateChart(revenueData) {
        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                datasets: [{
                    label: "Doanh thu",
                    data: revenueData,
                    backgroundColor: [
                        'rgba(85,85,85,1)',
                    ],
                    borderColor: [
                        'rgb(41,155,99)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    function fecthCategory() {
        var cate = new XMLHttpRequest();
        cate.open('GET', 'get_category_revenue.php', true);
        cate.onreadystatechange = function() {
            if (cate.readyState === 4 && cate.status === 200) {
                // Parse dữ liệu JSON nhận được thành một đối tượng JavaScript
                var responseData = JSON.parse(cate.responseText);
                // Truy cập vào mảng tên danh mục
                var categoryData = responseData.category_names;
                var categoryRevenueData = responseData.total_amounts;
                // Gọi hàm updateCategory và truyền vào mảng tên danh mục
                updateCategory(categoryData, categoryRevenueData);
            }
        };
        cate.send();
    }

    function updateCategory(categoryData, categoryRevenueData) {
        var ctx2 = document.getElementById('doughnut').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: categoryData,
                datasets: [{
                    label: 'Doanh thu theo tháng',
                    data: categoryRevenueData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 88, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    function fetchDayRevenue() {
        // Thực hiện một yêu cầu AJAX đến script PHP
        var dayReven = new XMLHttpRequest();
        dayReven.open('GET', 'get_day_revenue.php', true);
        dayReven.onreadystatechange = function() {
            if (dayReven.readyState === 4 && dayReven.status === 200) {
                var revenueDay = JSON.parse(dayReven.responseText);
                console.log(revenueDay);
                updateKpi(revenueDay);
            }
        };
        dayReven.send();
    }

    function updateKpi(revenueDay) {
        var ctx3 = document.getElementById('doughnut-kpi').getContext('2d');
        var tong = 1000000 - revenueDay
        var myChart3 = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Còn lại', 'Đạt'],
                datasets: [{
                    label: ['Còn lại', 'Đạt'],
                    data: [tong, revenueDay],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    function fetchProductRevenue() {
        var product = new XMLHttpRequest();
        product.open('GET', 'get_product_revenue.php', true);
        product.onreadystatechange = function() {
            if (product.readyState === 4 && product.status === 200) {
                // Parse dữ liệu JSON nhận được thành một đối tượng JavaScript
                var responseData = JSON.parse(product.responseText);
                console.log(responseData);
                // Truy cập vào mảng tên danh mục
                var productTitle = responseData.product_names;
                var totalRevenue = responseData.total_revenue;
                // Gọi hàm updateCategory và truyền vào mảng tên danh mục
                updateProductRevenue(productTitle, totalRevenue);
            }
        };
        product.send();
    }

    function updateProductRevenue(productTitle, totalRevenue) {
        var ctx4 = document.getElementById('revenue-product').getContext('2d');
        var myChart4 = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: productTitle,
                datasets: [{
                    label: "Doanh thu",
                    data: totalRevenue,
                    backgroundColor: [
                        'rgb(25,183,212)',
                    ],
                    borderColor: [
                        'rgb(41,155,99)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    function fetchYearRevenue() {
        var yearRevenue = new XMLHttpRequest();
        yearRevenue.open('GET', 'get_year_revenue.php', true);
        yearRevenue.onreadystatechange = function() {
            if (yearRevenue.readyState === 4 && yearRevenue.status === 200) {
                // Parse dữ liệu JSON nhận được thành một đối tượng JavaScript
                var responseData = JSON.parse(yearRevenue.responseText);
                console.log(responseData);
                // Truy cập vào mảng tên danh mục
                var year = responseData.years;
                var total_revenue = responseData.total_revenues;
                // Gọi hàm updateCategory và truyền vào mảng tên danh mục
                updateYearRevenue(year, total_revenue);
            }
        };
        yearRevenue.send();
    }

    function updateYearRevenue(year, total_revenue) {
        var ctx5 = document.getElementById('doughnut-year').getContext('2d');
        var myChart5 = new Chart(ctx5, {
            type: 'polarArea',
            data: {
                labels: year,
                datasets: [{
                    label: year,
                    data: total_revenue,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    function fetchProductRevenue() {
        var product = new XMLHttpRequest();
        product.open('GET', 'get_product_revenue.php', true);
        product.onreadystatechange = function() {
            if (product.readyState === 4 && product.status === 200) {
                // Parse dữ liệu JSON nhận được thành một đối tượng JavaScript
                var responseData = JSON.parse(product.responseText);
                console.log(responseData);
                // Truy cập vào mảng tên danh mục
                var productTitle = responseData.product_names;
                var totalRevenue = responseData.total_revenue;
                // Gọi hàm updateCategory và truyền vào mảng tên danh mục
                updateProductRevenue(productTitle, totalRevenue);
            }
        };
        product.send();
    }

    function updateProductRevenue(productTitle, totalRevenue) {
        var ctx4 = document.getElementById('revenue-product').getContext('2d');
        var myChart4 = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: productTitle,
                datasets: [{
                    label: "Doanh thu",
                    data: totalRevenue,
                    backgroundColor: [
                        'rgb(25,183,212)',
                    ],
                    borderColor: [
                        'rgb(41,155,99)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    function fetchUserRevenue() {
        var user = new XMLHttpRequest();
        user.open('GET', 'get_top_buys.php', true);
        user.onreadystatechange = function() {
            if (user.readyState === 4 && user.status === 200) {
                // Parse dữ liệu JSON nhận được thành một đối tượng JavaScript
                var responseData = JSON.parse(user.responseText);
                console.log(responseData);
                // Truy cập vào mảng tên danh mục
                var user_name = responseData.user_names;
                var total_spent = responseData.total_spent;
                // Gọi hàm updateCategory và truyền vào mảng tên danh mục
                updateUserRevenue(user_name, total_spent);
            }
        };
        user.send();
    }

    function updateUserRevenue(user_name, total_spent) {
        var ctx6 = document.getElementById('lineUser').getContext('2d');
        var myChart6 = new Chart(ctx6, {
            type: 'bar',
            data: {
                labels: user_name,
                datasets: [{
                    label: "Số tiền",
                    data: total_spent,
                    backgroundColor: [
                        'rgb(215,236,251)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    // Gọi hàm để lấy dữ liệu doanh thu hàng tháng khi trang tải
    window.onload = function() {
        fetchMonthlyRevenue();
        fecthCategory();
        fetchDayRevenue();
        fetchProductRevenue();
        fetchYearRevenue();
        fetchUserRevenue();
    };
</script>

</body>
</html>

