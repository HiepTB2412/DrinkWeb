<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'asm_php1');
function getRevenueByMonth() {
    $sql = "SELECT SUM(od.num * od.price) AS total_amount FROM orders o JOIN order_details od ON o.id = od.order_id WHERE DATE(o.order_date) = CURDATE();";
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    $result = mysqli_query($conn, $sql);
    $revenue_data = 0;
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $revenue_data = $row['total_amount'];
        }
    }
    
    // Trả về dữ liệu doanh thu dưới dạng JSON
    return json_encode($revenue_data);
}
$revenue_json = getRevenueByMonth();
if ($revenue_json){
    echo $revenue_json;
}else{
    echo "looix";
}
?>
