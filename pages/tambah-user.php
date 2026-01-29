<?php
// proteksi agar file tidak dapat diakses langsung
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordMd5 = md5($password);

    // upload foto profil
    $foto_profil_name = null;
    if (!empty($_FILES['foto_profil']['name'])) {
        $target_dir = "uploads/foto-profil/";
        $file_name = time() . "_" . basename($_FILES['foto_profil']['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file)) {
            $foto_profil_name = $file_name;
        }
    }

    // simpan ke database pelanggan
    $sql = "INSERT INTO pelanggan (nama_lengkap, foto_profil, email, password, alamat, no_telepon) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ssssss", $nama_lengkap, $foto_profil_name, $email, $passwordMd5, $alamat, $no_telepon);
        if ($stmt->execute()) {
            $pesan = "User berhasil ditambahkan";
        } else {
            $pesan_error = "Gagal menambahkan user: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tambah User</li>
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
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <input type="text" name="alamat" class="form-control" id="alamat" required>
                </div>
                <div class="mb-3">
                    <label for="no_telepon" class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" id="no_telepon" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="mb-3">
                    <label for="foto_profil" class="form-label">Upload Foto Profil</label>
                    <input class="form-control" name="foto_profil" type="file" id="foto_profil">
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?hal=daftar-user" class="btn btn-danger">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
