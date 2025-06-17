<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Mahasiswa</title>
<!-- Bagian StyleSheet daari bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
<!-- sStyle dasar untuk form -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-4 mb-5 px-5">
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1>
            </div>
            <!-- TEMPAT SEMUA FORM termasuk HASIL -->
            <div class="card-body">
                <!-- Pertanyaan dalam FORM -->
                <form method="post">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Masukkan Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Agus">
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Masukkan NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="202332xxx">
                    </div>
                    <div class="mb-3">
                        <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label>
                        <input type="number" class="form-control" id="kehadiran" name="kehadiran" placeholder="Untuk Lulus minimal 70%" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="tugas" class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" class="form-control" id="tugas" name="tugas" placeholder="0 - 100" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="uts" class="form-label">Nilai UTS (30%)</label>
                        <input type="number" class="form-control" id="uts" name="uts" placeholder="0 - 100" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="uas" class="form-label">Nilai UAS (40%)</label>
                        <input type="number" class="form-control" id="uas" name="uas" placeholder="0 - 100" min="0" max="100">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="proses" class="btn btn-primary">Proses</button>
                    </div>
                </form>

                <!-- Program Logika dan Data -->
                <?php
                // Untuk menerima dan mengambil data dengan metode POST dari form tadi
                    if (isset($_POST['proses'])) {
                    $nama = trim($_POST['nama']);
                    $nim = trim($_POST['nim']);
                    $kehadiran = trim($_POST['kehadiran']);
                    $tugas = trim($_POST['tugas']);
                    $uts = trim($_POST['uts']);
                    $uas = trim($_POST['uas']);

                // Cek kolom kosong ini untuk melihat dan membuat alert jika belum mengisi
                    $kosong = []; // declare list kosong bernilai kosong :v
                    if ($nama === '') $kosong[] = 'Nama';
                    if ($nim === '') $kosong[] = 'NIM';
                    if ($kehadiran === '') $kosong[] = 'Kehadiran';
                    if ($tugas === '') $kosong[] = 'Tugas';
                    if ($uts === '') $kosong[] = 'UTS';
                    if ($uas === '') $kosong[] = 'UAS';
                // Melakukan pengecekan list kemudian memberi peringatan
                    if (count($kosong) > 0) {
                        $daftarKolom = implode(' dan ', $kosong);
                        echo "
                        <div class='result-box mt-4 bg-danger text-white p-3 rounded'>
                            <strong>Kolom $daftarKolom harus diisi.</strong>
                        </div>";
                // Jika tidak kosong atau semuanya di isi, baru cek hasil
                    } else {
                        // Hitung nilai akhir
                        $nilai_akhir = ($kehadiran * 0.1) + ($tugas * 0.2) + ($uts * 0.3) + ($uas * 0.4);

                        // Cek kelulusan
                        // yang lulus cuma jika nilai lebih dari 60, kehadiran lebih dari 70, nilai komponen yang lain di atas 40 semua
                        if ($nilai_akhir >= 60 && $kehadiran >= 70 && $tugas >= 40 && $uts >= 40 && $uas >= 40) {
                            $status = "LULUS";
                            $gradeColor = "success";
                        } else {
                            $status = "TIDAK LULUS";
                            $gradeColor = "danger";
                        }

                        // Tampilkan hasil
                        echo "
                            <div class='result-box mt-4 border-$gradeColor rounded'>
                                <p class='text-center text-white py-2 bg-$gradeColor opacity-50 rounded-top fw-bold'>Hasil Penilaian</p>
                                <div class='p-3'>
                                    <div class='d-flex justify-content-center gap-5 text-center mb-3'>
                                        <h5><strong>Nama:</strong> $nama</h5>
                                        <h5><strong>NIM:</strong> $nim</h5>
                                    </div>
                                    <p class='mb-1'><strong>Nilai Kehadiran:</strong> $kehadiran</p>
                                    <p class='mb-1'><strong>Nilai Tugas:</strong> $tugas</p>
                                    <p class='mb-1'><strong>Nilai UTS:</strong> $uts</p>
                                    <p class='mb-1'><strong>Nilai UAS:</strong> $uas</p>
                                    <p class='mb-1'><strong>Nilai Akhir:</strong> " . number_format($nilai_akhir, 2) . "</p>
                                    <p class='mb-3'><strong>Status:</strong> 
                                        <span class='fw-bold " . ($status == 'LULUS' ? 'text-success' : 'text-danger') . "'>$status</span>
                                    </p>
                                    <div class='d-grid gap-2'>
                                        <a href='' class='btn btn-outline-light bg-$gradeColor opacity-50 fw-bold'>Selesai</a>
                                    </div>
                                </div>
                            </div>";
                        }
                    }

                ?>
            </div>
        </div>
    </div>
</body>
</html>