<?php
require_once('dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
use Dompdf\Options;

define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'asm_php1');

// Fetch current month revenue
$sql = "SELECT SUM(od.num * od.price) AS current_month_revenue FROM orders o JOIN order_details od ON o.id = od.order_id WHERE YEAR(o.order_date) = YEAR(CURRENT_DATE) AND MONTH(o.order_date) = MONTH(CURRENT_DATE);";
$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
$result = mysqli_query($conn, $sql);
$month_revenue = 0;

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $month_revenue = $row['current_month_revenue'];
}

// Configure Dompdf options
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Roboto');

$dompdf = new Dompdf($options);

// Font directory and file path
$fontDir = __DIR__ . '/font/'; // This resolves to the directory where the script is located, followed by '/font/'
$robotoFont = $fontDir . 'Roboto-Light.ttf';
$index = 1;

// Register the font
$dompdf->getOptions()->set('fontDir', $fontDir);
$dompdf->getOptions()->set('fontCache', $fontDir);

$html = '
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bao cao tai chinh</title>
    <style>
        @font-face {
            font-family: "Roboto";
            src: url("'. $robotoFont .'");
        }
        body {
            font-family: "Roboto", sans-serif;
        }
        .topbar {
            display: flex;
        }
        .address {
            flex: 1.4;
            text-align: center;
        }
        .address h3 {
            margin: 0;
        }
        .topbar-content {
            flex: 2;
            text-align: center;
        }
        .topbar-content h3, .topbar-content h5 {
            margin: 0;
        }
        .title h2, .title h4 {
            text-align: center;
            margin: 10px 0;
        }
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 25px auto;
            font-size: 18px;
            text-align: center;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: black;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .main_month_revenue_product h3 {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div class="address">
                <h3>Don vi: Cua hang 8</h3>
                <h3>Dia chi: 88 duong phen</h3>
            </div>
            <div class="topbar-content"><h3>Mau so B01 - DNSN</h3>
                <h5>(Ban hanh kem theo thong tu so 123/2024/TT-BTC <span>ngay 08/08/2024 cua bo tai chinh)</span></h5>
            </div>
        </div>
        <div class="title">
            <h2>Bao cao tinh hinh tai chinh thang ' . date('m/Y') . '</h2>
            <h4>Tai ngay ' . date('d') . ' thang ' . date('m') . ' nam ' . date('Y') . '</h4>
        </div>
        <div class="main_month_revenue_product">
            <h3>Tong doanh thu thang ' . date('m/Y') . ': ' . number_format($month_revenue, 0, ',', '.') . ' VND</h3>
            <table>
                <tr>
                    <th>STT</th>
                    <th>Ten san pham</th>
                    <th>Doanh thu</th>
                </tr>
                <tbody>
';

$sql1 = "SELECT p.title AS product_title, SUM(od.num * od.price) AS total_revenue FROM order_details od JOIN product p ON od.product_id = p.id JOIN orders o ON od.order_id = o.id WHERE MONTH(o.order_date) = MONTH(CURRENT_DATE) AND YEAR(o.order_date) = YEAR(CURRENT_DATE) GROUP BY p.title;";
$conn1 = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
$result1 = mysqli_query($conn1, $sql1);

foreach ($result1 as $row){
    $html .= '
        <tr>
            <td>' . ($index++) . '</td>
            <td>'.$row['product_title'].'</td>
            <td>'.$row['total_revenue'].'</td>
        </tr>
    ';
}

$html .= '
                    </tbody>
            </table>
        </div>
    </div>
</body>
</html>
';


$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('bao_cao_tai_chinh.pdf');
?>