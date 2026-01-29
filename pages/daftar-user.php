<?php
// proteksi agar file tidak dapat diakses langsung
if(!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

// ambil semua user/pelanggan dari tabel pelanggan
$sql = "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC";
$result = $mysqli->query($sql);

if (!$result) {
    die("Query error: " . $mysqli->error);
}

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar User</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <a href="index.php?hal=tambah-user" class="btn btn-primary mb-3">Tambah User Baru</a>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th style="width:5%">#</th>
                        <th style="width:25%">Nama</th>
                        <th style="width:20%">Email</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $no ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php if (!empty($row['foto_profil'])): ?>
                                    <img src="uploads/foto-profil/<?php echo $row['foto_profil']; ?>" 
                                         alt="<?php echo $row['nama_lengkap'] ?>" 
                                         width="60" height="80" 
                                         style="object-fit: cover; border-radius: 5px; margin-right: 10px;">
                                <?php else: ?>
                                    <div style="width:60px; height:80px; background:#ddd; border-radius:5px; margin-right:10px; display:flex; align-items:center; justify-content:center; color:#999;">
                                        No<br>Foto
                                    </div>
                                <?php endif; ?>

                                <div>
                                    <?php echo htmlspecialchars($row['nama_lengkap']); ?>
                                </div>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                        <td><?php echo htmlspecialchars($row['no_telepon']); ?></td>
                        <td>
                            <a href="index.php?hal=reset-password&id_pelanggan=<?php echo $row['id_pelanggan'] ?>" class='btn btn-warning btn-sm'>
                                <span class="me-2 fas fa-edit"></span>Ubah
                            </a>
                            <a href="index.php?hal=hapus-user&id_pelanggan=<?php echo $row['id_pelanggan'] ?>" class='btn btn-danger btn-sm' onclick="return confirm('Hapus user ini?')">
                                <span class="me-2 fas fa-trash"></span>Hapus
                            </a>
                        </td>
                    </tr>
                    <?php $no++; endwhile; ?>
                    <?php $mysqli->close(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
