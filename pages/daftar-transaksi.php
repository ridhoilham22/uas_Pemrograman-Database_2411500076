<?php
if (!defined('MY_APP')) die('Akses langsung tidak diperbolehkan!');

// Ambil semua transaksi
$sql = "SELECT t.*, p.nama_lengkap, s.nama_sepatu 
        FROM transaksi t
        JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
        JOIN sepatu s ON t.id_sepatu = s.id_sepatu
        ORDER BY t.id_transaksi DESC";

$result = $mysqli->query($sql);
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Transaksi</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
            <a href="index.php?hal=tambah-transaksi" class="btn btn-primary mb-3">Tambah Transaksi Baru</a>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>Sepatu</th>
                        <th>Tanggal Transaksi</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo $row['nama_lengkap'] ?></td>
                            <td><?php echo $row['nama_sepatu'] ?></td>
                            <td><?php echo $row['tanggal_transaksi'] ?></td>
                            <td><?php echo $row['tanggal_selesai'] ?></td>
                            <td><?php echo $row['status'] ?></td>
                            <td>
                                <a href="index.php?hal=ubah-transaksi&id=<?php echo $row['id_transaksi'] ?>" class="btn btn-primary btn-sm">Ubah</a>
                            </td>
                        </tr>
                    <?php $no++; endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
