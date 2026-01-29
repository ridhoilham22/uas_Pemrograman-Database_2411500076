<?php
// proteksi agar file tidak dapat diakses langsung
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

// ambil semua kategori sepatu
$sql = "SELECT * FROM kategori ORDER BY id_kategori DESC";
$result = $mysqli->query($sql);

if (!$result) {
    die("Query error: " . $mysqli->error);
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Kategori Sepatu</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Kategori Sepatu</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
            <a href="index.php?hal=tambah-kategori" class="btn btn-primary mb-3">Tambah Kategori</a>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Kategori Sepatu</th>
                        <th style="width:15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                            <td>
                                <a href="index.php?hal=ubah-kategori&id=<?php echo $row['id_kategori']; ?>" class='btn btn-primary btn-sm'>Ubah</a>
                            </td>
                        </tr>
                    <?php $no++; endwhile; ?>
                    <?php $mysqli->close(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
