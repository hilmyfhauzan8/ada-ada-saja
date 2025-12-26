<?php
require_once 'config.php';

$query_kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY id_kelas ASC");

if (!$query_kelas) {
    die('SQL error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peserta Globalin Academy</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="jquery-3.7.1.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .main-card { margin-top: -50px; border-radius: 15px; border: none; }
        .header-section { 
            background: linear-gradient(45deg, #007bff, #0056b3); 
            padding: 80px 0 100px 0; 
            color: white; 
        }
    </style>
</head>
<body>
    
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="header-section text-center">
        <img src="Screenshot (33).png" alt="Logo" width="30%">
        <br><br>
        <h1 class="fw-bold">GLOBALIN ACADEMY</h1>
        <p>Anggota & Absensi</p>
    </div>

    <div class="container mb-5">
        <div class="card main-card shadow-lg">
            <div class="card-header bg-white pt-3 px-4">
                <ul class="nav nav-tabs card-header-tabs" id="mainTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="anggota-tab" data-bs-toggle="tab" data-bs-target="#tab-anggota" type="button">
                            Daftar Anggota
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="tambah-anggota-tab" data-bs-toggle="tab" data-bs-target="#tab-tambah-anggota" type="button">
                            Tambah Anggota Baru
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#tab-absensi" type="button">
                            Absensi
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="mainTabContent">
                    
                    <div class="tab-pane fade show active" id="tab-anggota" role="tabpanel">
                        <div id="tampil-data">
                            <div class="text-center p-5">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2">Memuat data...</p>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-tambah-anggota" role="tabpanel">
                        <div class="mx-auto" style="max-width: 700px;">
                            <h4 class="mb-4 text-center">Formulir Pendaftaran</h4>
                            <form id="form-tambah-anggota">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama" required placeholder="Nama lengkap...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Alamat Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="nama@email.com">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Alamat Domisili</label>
                                    <textarea class="form-control" name="alamat" rows="2" required placeholder="Alamat lengkap..."></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Nomor Telepon</label>
                                        <input type="text" class="form-control" name="telpon" placeholder="0812xxxx">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Pilih Kelas</label>
                                        <select name="id_kelas" class="form-select" required>
                                            <option value="" disabled selected>-- Pilih Kelas --</option>
                                            <?php 
                                            mysqli_data_seek($query_kelas, 0);
                                            while ($kelas = mysqli_fetch_assoc($query_kelas)): ?>
                                                <option value="<?= $kelas['id_kelas']; ?>"><?= $kelas['nama_kelas']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold d-block">Jenis Kelamin</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="Pria" checked>
                                            <label class="form-check-label">Pria</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="Wanita">
                                            <label class="form-check-label">Wanita</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold d-block">Status</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" value="Aktif" checked>
                                            <label class="form-check-label">Aktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" value="Tidak aktif">
                                            <label class="form-check-label">Non-Aktif</label>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn btn-light border">Reset</button>
                                    <button type="submit" class="btn btn-primary px-4">Simpan Anggota</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-absensi" role="tabpanel">
                        <div class="text-center py-5">
                            <h3 class="text-muted">Fitur Absensi</h3>
                            <p>Halaman ini sedang dalam tahap pengembangan.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            tampil_data();

            $('#anggota-tab').on('click', function() {
                tampil_data();
            });

            $('#form-tambah-anggota').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'proses_simpan.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.trim() == "sukses") {
                            showToast("Data anggota berhasil ditambahkan!", "bg-success");
                            $('#form-tambah-anggota')[0].reset();
                        } else {
                            alert("Error: " + response);
                        }
                    }
                });
            });
        });

        function tampil_data() {
            $.ajax({
                url: 'get_data.php',
                type: 'GET',
                success: function(data) {
                    $('#tampil-data').html(data);
                }
            });
        }

        function showToast(message, bgColor) {
            $('#toastMessage').text(message);
            $('#liveToast').removeClass('bg-success bg-danger').addClass(bgColor);
            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
            toast.show();
        }
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>