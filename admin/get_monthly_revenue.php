<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'asm_php1');
function getRevenueByMonth() {
    $sql = "SELECT DATE_FORMAT(o.order_date, '%Y-%m') AS month, SUM(od.num * od.price) AS total_amount FROM orders o JOIN order_details od ON o.id = od.order_id WHERE YEAR(o.order_date) = YEAR(CURDATE()) GROUP BY DATE_FORMAT(o.order_date, '%Y-%m') ORDER BY month;";
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    $result = mysqli_query($conn, $sql);
    $revenue_data = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $revenue_data[] = $row['total_amount'];
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
