<?php include 'db/config.php'; ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Pemilihan Motor - AHP Method</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img class="rounded" src="img/logo.png" alt="SPK M-Punk Jaya">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kriteria">Kriteria</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#motor">Daftar Motor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#rekomendasi">Rekomendasi Hasil</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="tambah_motor.php" class="btn btn-outline-light me-2">
                        <i class="fas fa-plus-circle"></i> Tambah Motor
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Sistem Penunjang Keputusan Pemilihan Motor</h1>
            <p class="lead mb-5">Temukan motor terbaik sesuai kebutuhan Anda dengan metode Analytic Hierarchy Process
                (AHP)</p>
            <a href="#rekomendasi" class="btn btn-primary btn-lg px-4 me-2">
                <i class="fas fa-play"></i> Mulai Pemilihan
            </a>
            <a href="#motor" class="btn btn-outline-light btn-lg px-4">
                <i class="fas fa-motorcycle"></i> Lihat Daftar Motor
            </a>
        </div>
    </section>

    <section id="kriteria" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Kriteria Pemilihan</h2>
                <p class="text-muted">Berikut adalah kriteria yang digunakan dalam sistem ini</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="criteria-card text-center p-4">
                        <div class="criteria-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h4>Harga</h4>
                        <p class="text-muted">Harga beli dan biaya perawatan</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="criteria-card text-center p-4">
                        <div class="criteria-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h4>Kebutuhan</h4>
                        <p class="text-muted">Kebutuhan penggunaan motor seperti harian, kerja, koleksi, dan touring.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    include 'db/config.php';

    $limit = 6;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $limit;

    $result = mysqli_query($conn, "SELECT * FROM motor LIMIT $limit OFFSET $offset");

    $total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM motor");
    $total_row = mysqli_fetch_assoc($total_result);
    $total_data = $total_row['total'];
    $total_pages = ceil($total_data / $limit);
    ?>

    <section id="motor" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Daftar Motor</h2>
                <p class="text-muted">Pilih motor untuk dibandingkan</p>
            </div>
            <div class="row g-4">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($motor = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($motor['nama_motor']); ?></h5>
                                    <p class="text-muted">Rp <?= number_format($motor['harga'], 0, ',', '.'); ?></p>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-primary"></i> Penggunaan: <?= htmlspecialchars($motor['penggunaan']); ?></li>
                                    </ul>
                                    <a href="#rekomendasi" class="btn btn-primary w-100">Pilih untuk Perhitungan</a>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<p class="text-center">Belum ada data motor.</p>';
                }
                ?>
            </div>

            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link text-dark border-0 bg-transparent" href="?page=<?= $page - 1 ?>">Sebelumnya</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link <?= ($i == $page) ? 'bg-secondary text-white' : 'text-dark bg-transparent' ?> border-0" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link text-dark border-0 bg-transparent" href="?page=<?= $page + 1 ?>">Berikutnya</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

        </div>
    </section>

    <section id="rekomendasi" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Cari Rekomendasi</h2>
                <p class="text-muted">Rekomendasi motor berdasarkan harga dan kebutuhan</p>
            </div>
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Harga Maksimal</label>
                    <input type="number" name="harga_max" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kebutuhan</label>
                    <select name="penggunaan" class="form-select" required>
                        <option value="harian">Harian</option>
                        <option value="kerja">Kerja</option>
                        <option value="touring">Touring</option>
                        <option value="koleksi">Koleksi</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Cari Rekomendasi</button>
                </div>
            </form>
        </div>
    </section>
    <?php
    if (isset($_GET['harga_max']) && isset($_GET['penggunaan'])) {
        $hargaMax = (int) $_GET['harga_max'];
        $penggunaanInput = $_GET['penggunaan'];
        $hargaMin = 15000000; 

        $query = mysqli_query($conn, "SELECT * FROM motor WHERE harga BETWEEN $hargaMin AND $hargaMax AND penggunaan = '$penggunaanInput'");
        $kriteria = mysqli_query($conn, "SELECT * FROM kriteria");

        $bobot = [];
        while ($k = mysqli_fetch_assoc($kriteria)) {
            $bobot[$k['nama_kriteria']] = $k['bobot'];
        }

        $hasil = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $harga_score = 1 / $row['harga']; 
            $pemakaian_score = match ($row['penggunaan']) {
                'harian' => 0.9,
                'kerja' => 0.7,
                'touring' => 0.6,
                default => 0.5
            };

            $total = ($harga_score * $bobot['Harga']) + ($pemakaian_score * $bobot['Pemakaian']);

            $hasil[] = [
                'nama_motor' => $row['nama_motor'],
                'harga' => $row['harga'],
                'penggunaan' => $row['penggunaan'],
                'total' => $total
            ];
        }

        if (count($hasil) > 0) {
            usort($hasil, fn($a, $b) => $b['total'] <=> $a['total']);
            $terbaik = $hasil[0];
    ?>
            <div class="container py-4">
                <div class="alert alert-success">
                    <h4>Rekomendasi Terbaik:</h4>
                    <p><strong><?= htmlspecialchars($terbaik['nama_motor']) ?></strong> - Rp <?= number_format($terbaik['harga'], 0, ',', '.') ?> (<?= htmlspecialchars($terbaik['penggunaan']) ?>)</p>
                    <p>Skor AHP: <strong><?= round($terbaik['total'], 4) ?></strong></p>
                </div>
            </div>
    <?php
        } else {
            echo '<div class="container py-4"><div class="alert alert-warning">Tidak ditemukan motor dalam rentang harga Rp15.000.000 - Rp' . number_format($hargaMax, 0, ',', '.') . ' dan kebutuhan "' . htmlspecialchars($penggunaanInput) . '".</div></div>';
        }
    }
    ?>

    <?php
    include 'db/config.php';

    $motor = mysqli_query($conn, "SELECT * FROM motor");
    $kriteria = mysqli_query($conn, "SELECT * FROM kriteria");

    $bobot = [];
    while ($k = mysqli_fetch_assoc($kriteria)) {
        $bobot[$k['nama_kriteria']] = $k['bobot'];
    }

    $data = [];
    while ($m = mysqli_fetch_assoc($motor)) {
        $harga_score = 1 / $m['harga'];

        $pemakaian_score = match ($m['penggunaan']) {
            'harian' => 0.9,
            'kerja' => 0.7,
            'touring' => 0.6,
            default => 0.5
        };

        $total = ($harga_score * $bobot['Harga']) + ($pemakaian_score * $bobot['Pemakaian']);

        $data[] = [
            'nama_motor' => $m['nama_motor'],
            'harga' => $m['harga'], 
            'harga_score' => $harga_score,
            'pemakaian_score' => $pemakaian_score,
            'total' => $total
        ];
    }

    usort($data, fn($a, $b) => $b['total'] <=> $a['total']);
    $rekomendasi = $data[0];
    ?>

    <?php
    include 'db/config.php';

    $motor = mysqli_query($conn, "SELECT * FROM motor");
    $kriteria = mysqli_query($conn, "SELECT * FROM kriteria");

    $bobot = [];
    while ($k = mysqli_fetch_assoc($kriteria)) {
        $bobot[$k['nama_kriteria']] = $k['bobot'];
    }

    $data = [];
    while ($m = mysqli_fetch_assoc($motor)) {
        $harga_score = 1 / $m['harga'];

        $pemakaian_score = match ($m['penggunaan']) {
            'harian' => 0.9,
            'kerja' => 0.7,
            'touring' => 0.6,
            default => 0.5
        };

        $total = ($harga_score * $bobot['Harga']) + ($pemakaian_score * $bobot['Pemakaian']);

        $data[] = [
            'nama_motor' => $m['nama_motor'],
            'harga' => $m['harga'],
            'penggunaan' => $m['penggunaan'],
            'harga_score' => $harga_score,
            'pemakaian_score' => $pemakaian_score,
            'total' => $total
        ];
    }
    ?>

    <section id="hasil" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Hasil Perhitungan</h2>
                <p class="text-muted">Skor AHP dari semua motor yang tersedia</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0">Semua Motor</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="mt-4">Detail Perbandingan:</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kriteria</th>
                                            <?php foreach ($data as $d): ?>
                                                <th><?= htmlspecialchars($d['nama_motor']) ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Harga</td>
                                            <?php foreach ($data as $d): ?>
                                                <td><?= number_format($d['harga'], 0, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Pemakaian</td>
                                            <?php foreach ($data as $d): ?>
                                                <td><?= htmlspecialchars($d['penggunaan']) ?> (<?= round($d['pemakaian_score'], 2) ?>)</td>
                                            <?php endforeach; ?>
                                        </tr>

                                        <tr class="table-active">
                                            <td><strong>Skor AHP</strong></td>
                                            <?php foreach ($data as $d): ?>
                                                <td><strong><?= round($d['total'], 4) ?></strong></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    <div class="alert alert-info">
                                        <h5 class="fw-bold"><i class="fas fa-info-circle me-2"></i>Kesimpulan:</h5>
                                        <p>Berdasarkan hasil perhitungan AHP, motor dengan kebutuhan <strong>harian</strong> cenderung memiliki skor AHP tertinggi.
                                            Hal ini menunjukkan bahwa motor yang digunakan untuk aktivitas sehari-hari dianggap paling ideal berdasarkan kombinasi harga dan pemakaian.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Tentang Sistem Ini</h5>
                    <p>Sistem Pendukung Keputusan pemilihan motor menggunakan metode Analytic Hierarchy Process (AHP)
                        untuk membantu Anda menemukan motor terbaik sesuai kebutuhan.</p>
                </div>
                <div class="col-md-4">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> info@spkmotor.com</li>
                        <li><i class="fas fa-phone me-2"></i> (021) 12345678</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Bogor, Indonesia</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Beranda</a></li>
                        <li><a href="#kriteria" class="text-white">Kriteria</a></li>
                        <li><a href="#motor" class="text-white">Daftar Motor</a></li>
                        <li><a href="#ahp" class="text-white">Perhitungan AHP</a></li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 Daud Ferzian Ridho. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>