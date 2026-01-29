<?php
// Proteksi agar file tidak dapat diakses langsung
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

// Ambil semua sepatu
$sql = "SELECT * FROM sepatu ORDER BY id_sepatu DESC";
$result_sepatu = $mysqli->query($sql);

if (!$result_sepatu) {
    die("Query error: " . $mysqli->error);
}

// Ambil kategori per sepatu
$kategori_per_sepatu = [];
$sql_kategori = "
    SELECT sk.id_sepatu, k.nama_kategori
    FROM sepatu_kategori sk
    JOIN kategori k ON sk.id_kategori = k.id_kategori
";
$result_kategori = $mysqli->query($sql_kategori);
if ($result_kategori) {
    while ($row = $result_kategori->fetch_assoc()) {
        $kategori_per_sepatu[$row['id_sepatu']][] = $row['nama_kategori'];
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Sepatu</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Sepatu</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
            <a href="index.php?hal=tambah-sepatu" class="btn btn-primary mb-3">Tambah Sepatu Baru</a>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:25%">Nama Sepatu</th>
                        <th style="width:20%">Kategori</th>
                        <th>Merek</th>
                        <th>Ukuran</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    <?php while ($row = $result_sepatu->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if (!empty($row['gambar_sepatu'])): ?>
                                        <img src="uploads/<?php echo $row['gambar_sepatu']; ?>"
                                             alt="Gambar Sepatu"
                                             width="50" height="70"
                                             style="object-fit: cover; border-radius: 5px; margin-right: 10px;">
                                    <?php else: ?>
                                        <div style="width:50px; height:70px; background:#ddd; border-radius:5px; margin-right:10px; display:flex; align-items:center; justify-content:center; color:#999;">
                                            No<br>Image
                                        </div>
                                    <?php endif; ?>

                                    <div>
                                        <strong><?php echo htmlspecialchars($row['nama_sepatu']); ?></strong><br>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php
                                if (isset($kategori_per_sepatu[$row['id_sepatu']])) {
                                    echo implode(', ', $kategori_per_sepatu[$row['id_sepatu']]);
                                } else {
                                    echo '<em>Tidak ada</em>';
                                }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['merek']) ?></td>
                            <td><?php echo htmlspecialchars($row['ukuran']) ?></td>
                            <td><?php echo htmlspecialchars($row['tahun_rilis']) ?></td>
                            <td><?php echo htmlspecialchars($row['stok']) ?></td>
                            <td>
                                <a href="index.php?hal=ubah-sepatu&id=<?php echo $row['id_sepatu'] ?>" class='btn btn-primary btn-sm'>Ubah</a>
                            </td>
                        </tr>
                        <?php $no++; ?>
                    <?php endwhile; ?>
                    <?php $mysqli->close(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
