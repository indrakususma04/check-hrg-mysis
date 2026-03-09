<?php
header("Content-Type: application/json");
include "Koneksi.php"; // pastikan Koneksi.php tidak nge-echo apa pun

$barcode = isset($_GET['barcode']) ? $_GET['barcode'] : '';

if($barcode == ''){
    echo json_encode(["status"=>"error","message"=>"Barcode kosong"]);
    exit;
}

$query = "
SELECT BARA, NAMA, HJUAL AS harga1, HJUAL2 AS harga2, HJUAL3 AS harga3, QTY1 AS Q1, QTY2 AS Q2, QTY3 AS Q3, SATUAN
FROM mstock
WHERE BARA='$barcode' OR BARA2='$barcode'
";

$result = mysqli_query($conn, $query);
$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

if(count($data) == 0){
    echo json_encode(["status"=>"not_found","message"=>"Barang tidak ditemukan"]);
} else {
    echo json_encode(["status"=>"success","data"=>$data]);
}
exit;