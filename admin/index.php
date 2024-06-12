<?php require_once('database/dbhelper.php'); ?>
<?php
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thêm Sản Phẩm</title>
    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- summernote -->
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
</head>
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
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .main table {
        width: 90%;
    }

    .donhangmoi {
        width: 100%;
        display: flex;
        justify-content: center;
    }
</style>
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
        </div>
        <div class="sidebar">
            <ul>
                <li>
                    <a href="index.php" <?php if ($current_page == 'index.php') echo 'class="active"'; ?>>
                        <i class="fa-solid fa-chart-line"></i>
                        <div>Thống kê</div>
                    </a>
                </li>
                <li>
                    <a href="category/index.php" <?php if ($current_page == 'category/index.php') echo 'class="active"'; ?>>
                        <i class="fa-solid fa-bars-progress"></i>
                        <div>Quản lý danh mục</div>
                    </a>
                </li>
                <li>
                    <a href="product/" <?php if (strpos($_SERVER['REQUEST_URI'], '/product/') !== false) echo 'class="active"'; ?>>
                        <i class="fa-solid fa-mug-saucer"></i>
                        <div>Quản lý sản phẩm</div>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php" <?php if ($current_page == 'dashboard.php') echo 'class="active"'; ?>>
                        <i class="fa-solid fa-cart-shopping"></i>
                        <div>Quản lý đơn hàng</div>
                    </a>
                </li>
                <li>
                    <a href="customer.php" <?php if ($current_page == 'customer.php') echo 'class="active"'; ?>>
                        <i class="fa-solid fa-person"></i>
                        <div>Quản lý khách hàng</div>
                    </a>
                </li>
                <li>
                    <a href="revenue.php" <?php if ($current_page == 'revenue.php') echo 'class="active"'; ?>>
                        <i class="fa-solid fa-chart-simple"></i>
                        <div>Biểu đồ</div>
                    </a>
                </li>
            </ul>
        </div>

        
        <div class="main">
            <div class="donhangmoi"><h2>Đơn hàng mới</h2></div>
            <table>
                <tr class="bold">
                    <td>STT</td>
                    <td>Tên</td>
                    <td>Tên sản phẩm/Số lượng</td>
                    <td>Giá sản phẩm</td>
                    <td>Địa chỉ</td>
                    <td>Số điện thoại</td>
                </tr>
                <?php
                    try {
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                        $limit = 10;
                        $start = ($page - 1) * $limit;

                        $sql = "SELECT * FROM orders, order_details, product
                                WHERE order_details.order_id=orders.id 
                                AND product.id=order_details.product_id 
                                ORDER BY order_date DESC 
                                LIMIT $start,$limit";
                        $order_details_List = executeResult($sql);
                        $total = 0;
                        $count = 0;
                        
                        foreach ($order_details_List as $item) {
                            echo '
                                <tr>
                                    <td>' . (++$count) . '</td>
                                    <td>' . htmlspecialchars($item['fullname']) . '</td>
                                    <td>' . htmlspecialchars($item['title']) . '<br>(<strong>' . htmlspecialchars($item['num']) . '</strong>)</td>
                                    <td class="b-500 red">' . number_format($item['num'] * $item['price'], 0, ',', '.') . '<span> VNĐ</span></td>
                                    <td>' . htmlspecialchars($item['address']) . '</td>
                                    <td class="b-500 width-50px">' . htmlspecialchars($item['phone_number']) . '</td>
                                </tr>
                            ';
                        }
                    } catch (Exception $e) {
                        die("Lỗi thực thi sql: " . $e->getMessage());
                    }
                ?>
            </table>
        </div>
    </div>
</body>

