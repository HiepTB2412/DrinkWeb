<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'asm_php1');

function getRevenueByYear() {
    $sql = "SELECT YEAR(o.order_date) AS year, SUM(od.num * od.price) AS total_revenue 
            FROM order_details od 
            JOIN orders o ON od.order_id = o.id 
            GROUP BY YEAR(o.order_date)
            ORDER BY year;";
    
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $result = mysqli_query($conn, $sql);
    $years = array();
    $total_revenues = array();

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $years[] = $row['year'];
            $total_revenues[] = $row['total_revenue'];
        }
    }

    mysqli_close($conn);

    // Trả về dữ liệu doanh thu dưới dạng JSON
    return json_encode(array("years" => $years, "total_revenues" => $total_revenues));
}

$revenue_json = getRevenueByYear();

if ($revenue_json) {
    echo $revenue_json;
} else {
    echo "looix";
}
?>
