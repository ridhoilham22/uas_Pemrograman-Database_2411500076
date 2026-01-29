<?php
// proteksi agar file tidak dapat diakses langsung
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

// ambil data pelanggan berdasarkan id
if (isset($_GET['id_pelanggan']) && !empty($_GET['id_pelanggan'])) {
    $id_pelanggan = $_GET['id_pelanggan'];
    $sql = "SELECT * FROM pelanggan WHERE id_pelanggan = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $id_pelanggan);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $pelanggan = $result->fetch_assoc();
            } else {
                echo "Data user tidak ditemukan.";
                exit();
            }
        } else {
            echo "Terjadi kesalahan.";
            exit();
        }
        $stmt->close();
    }
} else {
    echo "User tidak ditemukan.";
    exit();
}

// update password pelanggan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = md5($_POST['password']);
    
    $sql = "UPDATE pelanggan SET password = ? WHERE id_pelanggan = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("si", $password, $id_pelanggan);
        if ($stmt->execute()) {
            $pesan = "Password <b>". htmlspecialchars($pelanggan['nama_lengkap']) . "</b> berhasil diubah!";
        } else {
            $pesan_error = "Terjadi kesalahan saat menyimpan data.";
        }
        $stmt->close();
    }
    $mysqli->close();
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Reset Password</li>
    </ol>

    <?php if (!empty($pesan)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $pesan ?>
        </div>
    <?php endif ?>

    <?php if (!empty($pesan_error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $pesan_error ?>
        </div>
    <?php endif ?>

    <div class="card mb-4">
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="nama_user" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_user" value="<?php echo htmlspecialchars($pelanggan['nama_lengkap']) ?>" disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="text" class="form-control" id="email" value="<?php echo htmlspecialchars($pelanggan['email']) ?>" disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Masukkan Password Baru</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?hal=daftar-user" class="btn btn-danger">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
