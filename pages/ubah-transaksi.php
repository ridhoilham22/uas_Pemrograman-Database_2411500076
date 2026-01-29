<?php
if (!defined('MY_APP')) die('Akses langsung tidak diperbolehkan!');

if (!isset($_GET['id'])) {
    header("Location: index.php?hal=daftar-transaksi");
    exit();
}

$id = $_GET['id'];

// ambil data transaksi
$stmt = $mysqli->prepare("SELECT * FROM transaksi WHERE id_transaksi = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows != 1) {
    die("Data transaksi tidak ditemukan");
}
$transaksi = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];

    // jika status berubah menjadi selesai dan sebelumnya dipinjam, tambah stok sepatu
    if ($transaksi['status'] == 'Dipinjam' && $status == 'Selesai') {
        $mysqli->query("UPDATE sepatu SET stok = stok + 1 WHERE id_sepatu = ".$transaksi['id_sepatu']);
    }

    $stmt = $mysqli->prepare("UPDATE transaksi SET status = ? WHERE id_transaksi = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        $pesan = "Status transaksi berhasil diperbarui";
        $transaksi['status'] = $status;
    } else {
        $pesan_error = "Gagal memperbarui status";
    }
    $stmt->close();
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Ubah Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Ubah Transaksi</li>
    </ol>

    <?php if (!empty($pesan)) : ?>
        <div class="alert alert-success"><?php echo $pesan ?></div>
    <?php endif; ?>
    <?php if (!empty($pesan_error)) : ?>
        <div class="alert alert-danger"><?php echo $pesan_error ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Dipinjam" <?php echo ($transaksi['status']=='Ditunda')?'selected':'' ?>>Ditunda</option>
                        <option value="Selesai" <?php echo ($transaksi['status']=='Selesai')?'selected':'' ?>>Selesai</option>
                        <option value="Batal" <?php echo ($transaksi['status']=='Gagal')?'selected':'' ?>>Batal</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="index.php?hal=daftar-transaksi" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>
                