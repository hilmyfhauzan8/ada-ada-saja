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
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="table-responsive">
                                    
                                    <table class="table table-striped table-hover table-bordered align-middle">
                                        <thead class="table-dark text-center">
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Anggota</th>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>Telpon</th>
                                                <th>Email</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Kelas</th>
                                                <th>Status</th>
                                                <th width="150px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="isi-tabel-anggota">
                                            </tbody>
                                    </table>

                                    <div id="loader" class="text-center d-none p-3">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <p class="mt-2">Memuat data...</p>
                                    </div>

                                </div>
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
                            <p>Belum jadi bang.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        let offset = 0;
        const limit = 20;
        let isLoading = false;
        let isFull = false;

        $(document).ready(function() {
            loadMoreData();

            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    if (!isLoading && !isFull) {
                        loadMoreData();
                    }
                }
            });

            $('#form-tambah-anggota').on('submit', function(e) {
                e.preventDefault();

                var formData = {
                    nama: $("input[name='nama']").val(),
                    alamat: $("textarea[name='alamat']").val(),
                    email: $("input[name='email']").val(),
                    telpon: $("input[name='telpon']").val(),
                    id_kelas: $("select[name='id_kelas']").val(),
                    jenis_kelamin: $("input[name='jenis_kelamin']:checked").val(),
                    status: $("input[name='status']:checked").val()
                };

                $.ajax({
                    url: 'saving_new_data.php',
                    type: 'POST',
                    contentType: 'application/json', 
                    data: JSON.stringify(formData), 
                    success: function(response) {
                        if (response.status == "success") {
                            showToast(response.message, "bg-success");
                            $('#form-tambah-anggota')[0].reset();
                            resetAndLoad();
                        }
                    },
                    error: function(xhr) {
                        var err = JSON.parse(xhr.responseText);
                        showToast("Error: " + err.message, "bg-danger");
                    }
                });
            });

            $('#anggota-tab').on('click', function() {
                resetAndReload();
            });
        });

        function resetAndReload() {
            offset = 0;
            isFull = false;
            $('#isi-tabel-anggota').empty();
            loadMoreData();
        }

        function loadMoreData() {
            isLoading = true;
            $('#loader').removeClass('d-none');

            $.ajax({
                url: `get_data.php?limit=${limit}&offset=${offset}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        let html = '';
                        data.forEach((row, index) => {
                            let no = offset + index + 1;
                            
                            let badgeKelas = row.nama_kelas 
                                ? `<span class="badge bg-primary">${row.nama_kelas}</span>` 
                                : `<span class="text-muted">-</span>`;
                            
                            let badgeStatus = row.status === 'Aktif' 
                                ? `<span class="badge bg-success">Aktif</span>` 
                                : `<span class="badge bg-secondary">Tidak Aktif</span>`;

                            html += `
                                <tr>
                                    <td class="text-center">${no}</td>
                                    <td class="text-center">${row.id_anggota}</td>
                                    <td class="fw-bold">${row.nama}</td>
                                    <td>${row.alamat}</td>
                                    <td>${row.telpon}</td>
                                    <td>${row.email}</td>
                                    <td class="text-center">${row.jenis_kelamin}</td>
                                    <td class="text-center">${badgeKelas}</td>
                                    <td class="text-center">${badgeStatus}</td>
                                    <td class="text-center">
                                        <a href="edit_data.php?id=${row.id_anggota}" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm" data-id="${row.id_anggota}" data-nama="${row.nama}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>`;
                        });

                        $('#isi-tabel-anggota').append(html);
                        offset += limit;
                    } else {
                        isFull = true;
                        if(offset > 0) {
                            $('#isi-tabel-anggota').append('<tr><td colspan="10" class="text-center p-3 text-muted">Semua data telah dimuat.</td></tr>');
                        } else {
                            $('#isi-tabel-anggota').append('<tr><td colspan="10" class="text-center p-5">Data Masih Kosong</td></tr>');
                        }
                    }
                    isLoading = false;
                    $('#loader').addClass('d-none');
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