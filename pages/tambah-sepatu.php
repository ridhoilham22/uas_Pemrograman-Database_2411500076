<?php
// Proteksi agar file tidak dapat diakses langsung
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_sepatu = $_POST['nama_sepatu'];
    $merek = $_POST['merek'];
    $ukuran = $_POST['ukuran'];
    $tahun_rilis = $_POST['tahun_rilis'];
    $stok = $_POST['stok'];

    // Upload gambar sepatu
    $gambar_name = null;
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES['gambar']['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $gambar_name = $file_name;
        }
    }

    // Insert data sepatu
    $sql = "INSERT INTO sepatu (nama_sepatu, merek, ukuran, tahun_rilis, stok, gambar_sepatu) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ssssis", $nama_sepatu, $merek, $ukuran, $tahun_rilis, $stok, $gambar_name);
        if ($stmt->execute()) {
            $id_sepatu = $stmt->insert_id;

            // Insert kategori sepatu jika dipilih
            if (!empty($_POST['kategori'])) {
                $stmt_kat = $mysqli->prepare("INSERT INTO sepatu_kategori (id_sepatu, id_kategori) VALUES (?, ?)");
                foreach ($_POST['kategori'] as $id_kat) {
                    $stmt_kat->bind_param("ii", $id_sepatu, $id_kat);
                    $stmt_kat->execute();
                }
                $stmt_kat->close();
            }

            $pesan = "Sepatu berhasil ditambahkan.";
        } else {
            $pesan_error = "Gagal menambahkan sepatu.";
        }
        $stmt->close();
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Sepatu</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tambah Sepatu</li>
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
            <form action="index.php?hal=tambah-sepatu" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_sepatu" class="form-label">Nama Sepatu</label>
                    <input type="text" name="nama_sepatu" class="form-control" id="nama_sepatu" required>
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori Sepatu</label><br>
                    <?php
                    $result_kategori = $mysqli->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
                    while ($kat = $result_kategori->fetch_assoc()) :
                    ?>
                        <label class='me-3'>
                            <input type='checkbox' name='kategori[]' value='<?php echo $kat['id_kategori'] ?>'> <?php echo $kat['nama_kategori'] ?>
                        </label>
                    <?php endwhile ?>
                </div>

                <div class="mb-3">
                    <label for="merek" class="form-label">Merek</label>
                    <input type="text" name="merek" class="form-control" id="merek" required>
                </div>

                <div class="mb-3">
                    <label for="ukuran" class="form-label">Ukuran</label>
                    <input type="text" name="ukuran" class="form-control" id="ukuran" required>
                </div>

                <div class="mb-3">
                    <label for="tahun_rilis" class="form-label">Tahun Rilis</label>
                    <input type="text" name="tahun_rilis" class="form-control" id="tahun_rilis" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" id="stok" required>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Upload Gambar Sepatu</label>
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
