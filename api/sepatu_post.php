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

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    response("error", "Gunakan metode POST.!!");
}

$nama_sepatu  = $_POST['nama_sepatu'] ?? '';
$merek        = $_POST['merek'] ?? '';
$ukuran       = $_POST['ukuran'] ?? '';
$tahun_rilis  = $_POST['tahun_rilis'] ?? '';
$stok         = $_POST['stok'] ?? '';
$gambar_sepatu = $_POST['gambar_sepatu'] ?? '';

if (
    $nama_sepatu === '' ||
    $merek === '' ||
    $ukuran === '' ||
    $tahun_rilis === '' ||
    $stok === '' ||
    $gambar_sepatu === ''
) {
    response("error", "Data sepatu tidak lengkap.");
}

/* =========================
   INSERT KE DATABASE
   ========================= */
$stmt = $mysqli->prepare(
    "INSERT INTO sepatu 
    (nama_sepatu, merek, ukuran, tahun_rilis, stok, gambar_sepatu)
    VALUES (?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "ssssis",
    $nama_sepatu,
    $merek,
    $ukuran,
    $tahun_rilis,
    $stok,
    $gambar_sepatu
);

if ($stmt->execute()) {
    response("success", "Data sepatu berhasil ditambahkan.", [
        "id_sepatu" => $stmt->insert_id,
        "nama_sepatu" => $nama_sepatu,
        "merek" => $merek,
        "gambar_sepatu" => "http://10.219.223.13/tokosepatu/uploads/" . $gambar_sepatu
    ]);
} else {
    response("error", "Gagal menambahkan data sepatu.");
}

$stmt->close();
$mysqli->close();
