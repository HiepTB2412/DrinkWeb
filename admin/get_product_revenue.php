<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'asm_php1');

function getRevenueByMonth() {
    $sql = "SELECT p.title AS product_title, SUM(od.num * od.price) AS total_revenue FROM order_details od JOIN product p ON od.product_id = p.id JOIN orders o ON od.order_id = o.id WHERE MONTH(o.order_date) = MONTH(CURRENT_DATE) AND YEAR(o.order_date) = YEAR(CURRENT_DATE) GROUP BY p.title;";
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $result = mysqli_query($conn, $sql);
    $product_titles = array();
    $total_revenues = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $product_titles[] = $row['product_title'];
            $total_revenues[] = $row['total_revenue'];
        }
    }

    mysqli_close($conn);

    // Trả về dữ liệu doanh thu dưới dạng JSON
    return json_encode(array("product_names" => $product_titles, "total_revenue" => $total_revenues));
}
$revenue_json = getRevenueByMonth();

if ($revenue_json){
    echo $revenue_json;
}else{
    echo "looix";
}
?>
