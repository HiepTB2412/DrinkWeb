<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'asm_php1');

function getProductbyNumber(){
    $sql="SELECT order_details.num, product.title FROM order_details JOIN product ON order_details.product_id = product.id WHERE order_details.num > 1;";
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $result = mysqli_query($conn, $sql);
    $product_titles=array();
    $product_nums=array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $product_titles[] = $row['product_title'];
            $total_nums[] = $row['total_num'];
        }
    }

    mysqli_close($conn);
    return json_encode(array("product_title" => $product_titles, "total_num" => $total_nums));
}
$product_json=getProductbyNumber();
if ($revenue_json){
    echo $revenue_json;
}else{
    echo "looix";
}
?>