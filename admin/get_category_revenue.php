<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'asm_php1');
function getRevenueByMonth() {
    $sql = "SELECT c.name AS category_name, SUM(od.num * od.price) AS total_amount FROM order_details od JOIN product p ON od.product_id = p.id JOIN category c ON p.id_category = c.id JOIN orders o ON od.order_id = o.id WHERE YEAR(o.order_date) = YEAR(CURDATE()) AND MONTH(o.order_date) = MONTH(CURDATE()) GROUP BY c.name, c.id ORDER BY c.id;";
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    $result = mysqli_query($conn, $sql);
    $category_names = array();
    $total_amounts = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $category_names[] = $row['category_name'];
            $total_amounts[] = $row['total_amount'];
        }
    }
    
    // Trả về dữ liệu doanh thu dưới dạng JSON
    return json_encode(array("category_names" => $category_names, "total_amounts" => $total_amounts));
}
$revenue_json = getRevenueByMonth();

if ($revenue_json){
    echo $revenue_json;
}else{
    echo "looix";
}
?>
