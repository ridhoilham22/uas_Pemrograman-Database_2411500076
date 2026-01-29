<?php

require "../includes/config.php";

function response($status, $msg, $data = null) {
    echo json_encode([
        "status" => $status,
        "message" => $msg,
        "data" => $data
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    response("error", "Gunakan metode GET.!!");
}

$result = $mysqli->query("SELECT id_sepatu, nama_sepatu, merek, gambar_sepatu FROM sepatu ORDER BY id_sepatu DESC");

$daftar = [];
while ($row = $result->fetch_assoc()) {
    $daftar[] = [
        "id_sepatu" => $row['id_sepatu'],
        "nama_sepatu" => $row['nama_sepatu'],
        "merek" => $row['merek'],  
        "gambar_sepatu" => "http://10.219.223.13/tokosepatu/uploads/" . $row['gambar_sepatu']
    ];
}

response("success", "Daftar sepatu berhasil diambil.", $daftar);
