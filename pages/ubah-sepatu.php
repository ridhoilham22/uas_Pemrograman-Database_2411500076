<?php
// Proteksi agar file tidak dapat diakses langsung
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

// Ambil data sepatu berdasarkan ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM sepatu WHERE id_sepatu = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $sepatu = $result->fetch_assoc();
            } else {
                echo "Data sepatu tidak ditemukan.";
                exit();
            }
        } else {
            echo "Error.";
            exit();
        }
        $stmt->close();
    }
} else {
    header("location: index.php?hal=daftar-sepatu");
}

// Proses update sepatu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_sepatu = $_POST['nama_sepatu'];
    $merek = $_POST['merek'];
    $ukuran = $_POST['ukuran'];
    $tahun_rilis = $_POST['tahun_rilis'];
    $stok = $_POST['stok'];

    $gambar_name = $sepatu['gambar_sepatu'];

    // Upload gambar baru jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES['gambar']['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $gambar_name = $file_name;
            // hapus gambar lama
            if (!empty($sepatu['gambar_sepatu']) && file_exists($target_dir . $sepatu['gambar_sepatu'])) {
                unlink($target_dir . $sepatu['gambar_sepatu']);
            }
        }
    }

    $sql = "UPDATE sepatu SET nama_sepatu = ?, merek = ?, ukuran = ?, tahun_rilis = ?, stok = ?, gambar_sepatu = ? WHERE id_sepatu = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssissi", $nama_sepatu, $merek, $ukuran, $tahun_rilis, $stok, $gambar_name, $id);
        if ($stmt->execute()) {
            // hapus dulu relasi kategori lama
            $mysqli->query("DELETE FROM sepatu_kategori WHERE id_sepatu = $id");
            // masukkan kategori baru
            if (!empty($_POST['kategori'])) {
                $stmt_kat = $mysqli->prepare("INSERT INTO sepatu_kategori (id_sepatu, id_kategori) VALUES (?, ?)");
                foreach ($_POST['kategori'] as $id_kat) {
                    $stmt_kat->bind_param("ii", $id, $id_kat);
                    $stmt_kat->execute();
                }
                $stmt_kat->close();
            }
            $pesan = "Data sepatu berhasil diperbarui.";
            // refresh data sepatu agar perubahan langsung terlihat
            $result = $mysqli->query("SELECT * FROM sepatu WHERE id_sepatu = $id");
            $sepatu = $result->fetch_assoc();
        } else {
            $pesan_error = "Gagal memperbarui sepatu.";
        }
        $stmt->close();
    } else {
        $pesan_error = "Kesalahan dalam query update.";
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Sepatu</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Ubah Sepatu</li>
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
                    <label for="nama_sepatu" class="form-label">Nama Sepatu</label>
                    <input type="text" name="nama_sepatu" class="form-control" id="nama_sepatu" value="<?php echo $sepatu['nama_sepatu'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori Sepatu</label><br>
                    <?php
                    $sql = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
                    $result_kategori = $mysqli->query($sql);

                    $kategori_sepatu = [];
                    $sql_kat = "SELECT id_kategori FROM sepatu_kategori WHERE id_sepatu = ?";
                    if ($stmt_kat = $mysqli->prepare($sql_kat)) {
                        $stmt_kat->bind_param("i", $id);
                        $stmt_kat->execute();
                        $result_kat = $stmt_kat->get_result();
                        while ($row_kat = $result_kat->fetch_assoc()) {
                            $kategori_sepatu[] = $row_kat['id_kategori'];
                        }
                        $stmt_kat->close();
                    }
                    ?>

                    <?php while ($kat = $result_kategori->fetch_assoc()) : ?>
                        <label class='me-3'>
                            <input type='checkbox'
                                name='kategori[]'
                                value='<?php echo $kat['id_kategori'] ?>'
                                <?php echo in_array($kat['id_kategori'], $kategori_sepatu) ? 'checked' : ''; ?>>
                            <?php echo $kat['nama_kategori'] ?>
                        </label>
                    <?php endwhile ?>
                </div>

                <div class="mb-3">
                    <label for="merek" class="form-label">Merek</label>
                    <input type="text" name="merek" class="form-control" id="merek" value="<?php echo $sepatu['merek'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="ukuran" class="form-label">Ukuran</label>
                    <input type="text" name="ukuran" class="form-control" id="ukuran" value="<?php echo $sepatu['ukuran'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tahun_rilis" class="form-label">Tahun Rilis</label>
                    <input type="number" name="tahun_rilis" class="form-control" id="tahun_rilis" value="<?php echo $sepatu['tahun_rilis'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" id="stok" value="<?php echo $sepatu['stok'] ?>" required>
                </div>

                <div class="mb-3">
                    <img src="uploads/<?php echo $sepatu['gambar_sepatu'] ?>" width="100" height="140" />
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Ganti Gambar</label>
                    <input class="form-control" name="gambar" type="file" id="gambar">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?hal=daftar-sepatu" class="btn btn-danger">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
