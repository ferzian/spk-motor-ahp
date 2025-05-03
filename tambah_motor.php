<?php include 'db/config.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tambah Data Motor</h2>
        <form method="POST" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label class="form-label">Nama Motor</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" min="15000000" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Pemakaian</label>
                <select name="penggunaan" class="form-select" required>
                    <option value="" selected disabled>Pilih Jenis Pemakaian</option>
                    <option value="harian">Harian</option>
                    <option value="touring">Touring</option>
                    <option value="kerja">Kerja</option>
                    <option value="koleksi">Koleksi</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="index.php" class="btn btn-secondary ms-2">Kembali ke Beranda</a>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama = trim($_POST['nama']);
        $harga = intval($_POST['harga']);
        $penggunaan = $_POST['penggunaan'];

        // Validasi PHP tambahan
        if ($nama === '' || $harga < 15000000) {
            echo "<script>alert('Nama tidak boleh kosong dan harga minimal Rp15.000.000');</script>";
        } else {
            if (mysqli_query($conn, "INSERT INTO motor (nama_motor, harga, penggunaan) VALUES ('$nama', $harga, '$penggunaan')")) {
                echo "<script>
                        alert('Data berhasil ditambahkan!');
                        window.location.href = 'index.php';
                      </script>";
            } else {
                echo "<script>alert('Gagal menambahkan data!');</script>";
            }
        }
    }
    ?>
</body>

</html>
