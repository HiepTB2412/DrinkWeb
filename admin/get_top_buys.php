<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'asm_php1');

function getTopBuyers() {
    $sql = "SELECT u.hoten AS user_name, SUM(od.num * od.price) AS total_spent 
            FROM order_details od 
            JOIN user u ON od.id_user = u.id_user 
            GROUP BY u.hoten 
            ORDER BY total_spent DESC 
            LIMIT 3;";
    
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $result = mysqli_query($conn, $sql);
    $user_names = array();
    $total_spent = array();

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $user_names[] = $row['user_name'];
            $total_spent[] = $row['total_spent'];
        }
    }

    mysqli_close($conn);

    // Trả về dữ liệu người mua nhiều hàng nhất dưới dạng hai mảng JSON riêng biệt
    return json_encode(array("user_names" => $user_names, "total_spent" => $total_spent));
}

$top_buyers_json = getTopBuyers();

if ($top_buyers_json) {
    echo $top_buyers_json;
} else {
    echo "looix";
}
?>
