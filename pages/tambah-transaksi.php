<?php
// proteksi agar file tidak dapat diakses langsung
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_sepatu = $_POST['id_sepatu'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status = $_POST['status'];

    // cek stok sepatu
    $stmt_stok = $mysqli->prepare("SELECT stok FROM sepatu WHERE id_sepatu = ?");
    $stmt_stok->bind_param("i", $id_sepatu);
    $stmt_stok->execute();
    $result_stok = $stmt_stok->get_result();
    $sepatu = $result_stok->fetch_assoc();
    $stmt_stok->close();

    if ($sepatu['stok'] <= 0 && $status == 'Dipinjam') {
        $pesan_error = "Stok sepatu tidak cukup!";
    } else {
        $sql = "INSERT INTO transaksi (tanggal_transaksi, tanggal_selesai, status, id_pelanggan, id_sepatu)
                VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sssii", $tanggal_transaksi, $tanggal_selesai, $status, $id_pelanggan, $id_sepatu);
            if ($stmt->execute()) {
                // kurangi stok sepatu jika status = Dipinjam
                if ($status == 'Dipinjam') {
                    $mysqli->query("UPDATE sepatu SET stok = stok - 1 WHERE id_sepatu = $id_sepatu");
                }
                $pesan = "Transaksi berhasil ditambahkan.";
            } else {
                $pesan_error = "Gagal menambahkan transaksi.";
            }
            $stmt->close();
        }
    }
}

// Ambil data pelanggan
$result_pelanggan = $mysqli->query("SELECT * FROM pelanggan ORDER BY nama_lengkap ASC");

// Ambil data sepatu
$result_sepatu = $mysqli->query("SELECT * FROM sepatu ORDER BY nama_sepatu ASC");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tambah Transaksi</li>
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
                    <label class="form-label">Pelanggan</label>
                    <select name="id_pelanggan" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php while ($pel = $result_pelanggan->fetch_assoc()) : ?>
                            <option value="<?php echo $pel['id_pelanggan'] ?>"><?php echo $pel['nama_lengkap'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sepatu</label>
                    <select name="id_sepatu" class="form-control" required>
                        <option value="">-- Pilih Sepatu --</option>
                        <?php while ($sep = $result_sepatu->fetch_assoc()) : ?>
                            <option value="<?php echo $sep['id_sepatu'] ?>">
                                <?php echo $sep['nama_sepatu'] ?> (Stok: <?php echo $sep['stok'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Ditunda">Ditunda</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Batal">Gagal</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="index.php?hal=daftar-transaksi" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>
