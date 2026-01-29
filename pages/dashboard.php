<?php
// proteksi agar file tidak diakses langsung
if(!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

// Koneksi database langsung
$db = new mysqli("localhost", "root", "", "tokosepatu");
if($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

// Ambil data untuk dashboard
$total_sepatu = $db->query("SELECT COUNT(*) AS total FROM sepatu")->fetch_assoc()['total'];
$total_pelanggan = $db->query("SELECT COUNT(*) AS total FROM pelanggan")->fetch_assoc()['total'];
$total_booking = $db->query("SELECT COUNT(*) AS total FROM transaksi")->fetch_assoc()['total'];

// Ambil 10 sepatu terbaru
$sepatu_terbaru = $db->query("
    SELECT s.nama_sepatu, s.merek, s.ukuran, s.tahun_rilis, s.stok
    FROM sepatu s
    ORDER BY s.id_sepatu DESC
    LIMIT 10
")->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Toko Sepatu</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-3 p-3">
                <h2><?= $total_sepatu ?></h2>
                <p>Total Sepatu</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-3 p-3">
                <h2><?= $total_pelanggan ?></h2>
                <p>Total Pelanggan</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white mb-3 p-3">
                <h2><?= $total_booking ?></h2>
                <p>Total Booking</p>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Sepatu Terbaru</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Sepatu</th>
                        <th>Merek</th>
                        <th>Ukuran</th>
                        <th>Tahun Rilis</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($sepatu_terbaru as $sepatu): ?>
                    <tr>
                        <td><?= $sepatu['nama_sepatu'] ?></td>
                        <td><?= $sepatu['merek'] ?></td>
                        <td><?= $sepatu['ukuran'] ?></td>
                        <td><?= $sepatu['tahun_rilis'] ?></td>
                        <td><?= $sepatu['stok'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
