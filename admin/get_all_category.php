<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'asm_php1');
function getRevenueByMonth() {
    $sql = "SELECT name FROM category;";
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    $result = mysqli_query($conn, $sql);
    $revenue_data = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $revenue_data[] = $row['name'];
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
