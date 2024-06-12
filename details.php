<?php require_once('database/dbhelper.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Thêm Sản Phẩm</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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

    <style>
        #wrapper {
            padding-bottom: 5rem;
        }

        .b-500 {
            font-weight: 500;
        }

        .red {
            color: red;
        }

        .green {
            color: green;
        }

        .nav-tabs .nav-item .nav-link:hover {
            background-color: #0056b3;
            color: white;
        }

        .nav-tabs {
            flex-direction: column;
            width: 200px;
        }

        .nav-tabs .nav-item {
            width: 100%;
        }

        .nav-tabs .nav-item .nav-link {
            border-radius: 0;
            text-align: left;
        }

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh; /* Full height to center vertically */
        }

        .table-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 1rem;
            text-align: center;
        }

    </style>
</head>

<body>
    <div id="wrapper" class="container-fluid">
        <header>
            <h1>Quản Lý Sản Phẩm</h1>
        </header>
        <div class="row">
            <div class="col-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="category/index.php">Thống kê</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category/index.php">Quản lý danh mục</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product/">Quản lý sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Quản lý đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer.php">Quản lý khách hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="revenue.php">Biểu đồ</a>
                    </li>
                </ul>
            </div>
            <div class="col-9 main-content">
                <main>
                    <section class="new-order">
                        <h4>Đơn hàng mới</h4>
                        <div class="table-container">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên</th>
                                        <th>Tên sản phẩm/Số lượng</th>
                                        <th>Giá sản phẩm</th>
                                        <th>Địa chỉ</th>
                                        <th>Số điện thoại</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        try {
                                            if (isset($_GET['page'])) {
                                                $page = $_GET['page'];
                                            } else {
                                                $page = 1;
                                            }
                                            $limit = 10;
                                            $start = ($page - 1) * $limit;

                                            $sql = "SELECT * from orders, order_details, product
                                            where order_details.order_id=orders.id and product.id=order_details.product_id ORDER BY order_date DESC limit $start,$limit ";
                                            $order_details_List = executeResult($sql);
                                            $total = 0;
                                            $count = 0;
                                            foreach ($order_details_List as $item) {
                                                echo '
                                                    <tr style="text-align: center;">
                                                        <td>' . (++$count) . '</td>
                                                        <td>' . $item['fullname'] . '</td>
                                                        <td>' . $item['title'] . '<br>(<strong>' . $item['num'] . '</strong>)</td>
                                                        <td class="b-500 red">' . number_format($item['num'] * $item['price'], 0, ',', '.') . '<span> VNĐ</span></td>
                                                        <td>' . $item['address'] . '</td>
                                                        <td class="b-500">' . $item['phone_number'] . '</td>
                                                    </tr>
                                                ';
                                            }
                                        } catch (Exception $e) {
                                            die("Lỗi thực thi sql: " . $e->getMessage());
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
</body>

</html>
