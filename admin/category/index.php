<?php
require_once('../database/dbhelper.php');
?>
<?php
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thêm danh mục</title>
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
    #container {
        width: 100%;
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

    .qldmuc {
        width: 100%;
        display: flex;
        justify-content: center;
        height: fit-content;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .main table {
        width: 90%;
        margin: auto;
        text-align: center;
    }

    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    td {
        height: 50px;
    }

    .newCategory {
        text-align: left;
        margin-left: 65px;
        padding: 10px;
        background-color: #299b63;
        border: none;
        border-radius: 5px;
        color: #fff;
    }

    .btnUpdate {
        text-align: left;
        padding: 10px;
        background-color: #5bc4e8;
        border: none;
        border-radius: 5px;
        color: #fff;
    }

    .btnDelete {
        text-align: left;
        padding: 10px;
        background-color: #f50307;
        border: none;
        border-radius: 5px;
        color: #fff;
    }
</style>
<body>
    <div id="container">
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
                    <a href="../index.php" class="<?php echo $current_page == 'index.php' && $current_dir == 'your_parent_dir' ? 'active' : ''; ?>">
                        <i class="fa-solid fa-chart-line"></i>
                        <div>Thống kê</div>
                    </a>
                </li>
                <li>
                    <a href="index.php" class="<?php echo $current_page == 'index.php' && $current_dir == 'category' ? 'active' : ''; ?>">
                        <i class="fa-solid fa-bars-progress"></i>
                        <div>Quản lý danh mục</div>
                    </a>
                </li>
                <li>
                    <a href="../product/" <?php if(strpos($_SERVER['PHP_SELF'], '/product/') !== false) echo 'class="active"'; ?>>
                        <i class="fa-solid fa-mug-saucer"></i>
                        <div>Quản lý sản phẩm</div>
                    </a>
                </li>
                <li>
                    <a href="../dashboard.php" <?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php') echo 'class="active"'; ?>>
                        <i class="fa-solid fa-cart-shopping"></i>
                        <div>Quản lý đơn hàng</div>
                    </a>
                </li>
                <li>
                    <a href="../customer.php" <?php if(basename($_SERVER['PHP_SELF']) == 'customer.php') echo 'class="active"'; ?>>
                        <i class="fa-solid fa-person"></i>
                        <div>Quản lý khách hàng</div>
                    </a>
                </li>
                <li>
                    <a href="../revenue.php" <?php if(basename($_SERVER['PHP_SELF']) == 'revenue.php') echo 'class="active"'; ?>>
                        <i class="fa-solid fa-chart-simple"></i>
                        <div>Biểu đồ</div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main">
            <div class="qldmuc"><h2>Quản lý danh mục</h2></div>
            <a href="add.php">
                    <button class="newCategory" style="margin-bottom:20px">Thêm Danh Mục</button>
            </a>
            <table>
                <tr class="bold">
                    <th>STT</th>
                    <th>Tên danh mục</th>
                    <th>Action</th>
                    <th>Action</th>
                </tr>
                <?php
                // Lấy danh sách danh mục
                $sql = 'SELECT * FROM category';
                $categoryList = executeResult($sql);
                $index = 1;
                foreach ($categoryList as $item) {
                    echo '<tr>
                            <td>' . $index++ . '</td>
                            <td>' . htmlspecialchars($item['name']) . '</td>
                            <td>
                                <a href="add.php?id=' . $item['id'] . '">
                                    <button class="btnUpdate">Sửa</button>
                                </a>
                            </td>
                            <td>
                                <button class="btnDelete" onclick="deleteCategory(' . $item['id'] . ')">Xoá</button>
                            </td>
                        </tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>

<script type="text/javascript">
    function deleteCategory(id) {
        var option = confirm('Bạn có chắc chắn muốn xoá danh mục này không?')
        if(!option) {
            return;
        }
        console.log(id)
        $.post('ajax.php', {
            'id': id,
            'action': 'delete'
        }, function(data) {
            location.reload()
        })
    }
</script>