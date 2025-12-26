<?php

require_once 'config.php';

$sql = 'SELECT a.*, k.nama_kelas FROM anggota as a
        LEFT JOIN kelas as k ON a.id_kelas = k.id_kelas
        GROUP BY a.id_anggota
        ORDER BY a.id_anggota ASC';

$query = mysqli_query($conn, $sql);
$query_kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY id_kelas ASC");

if (!$query) {
    die('SQL error: ' . mysqli_error($conn));
};

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
        h2 {
            margin-top: 30px;
            margin-bottom: 30px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container" id="eyyo">

        <h2 class="text-center text-primary">DAFTAR ANGGOTA PHP</h2>

        <div class="card shadow-sm">

            <div class="card-header bg-white py-3">
                <a id="tambah-baru-php" class="btn btn-primary">
                + Tambah Data Baru
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    
                    <table class="table table-striped table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">ID Anggota</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Telpon</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Jenis Kelamin</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($query)){
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($row['id_anggota']); ?></td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                    <td><?php echo htmlspecialchars($row['telpon']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                                    <td class="text-center">
                                        <?php if ($row['nama_kelas']): ?>
                                            <span class="badge bg-primary"><?php echo htmlspecialchars($row['nama_kelas']); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($row['status'] == 'Aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <a href="edit_data.php?id=<?php echo $row['id_anggota'];?>" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" 
                                            class="btn btn-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalHapus" 
                                            data-id="<?php echo $row['id_anggota'];?>" 
                                            data-nama="<?php echo $row['nama'];?>">
                                        Hapus
                                    </button>
                                    </td>
                                </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="10" class="text-center p-5">
                                        Data Masih Kosong
                                    </td>
                                </tr>
                            <?php }; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
        <br><br>

        <button class="btn btn-primary" id="js">Belajar javaaaaskrraak</button>
        <br><br><br>
    </div>

    <div class="container" id="heheyy">
        <h2 class="text-center text-primary">Anggota javaaaaskrraak</h2>
        
        <div class="card-header bg-white py-3">
            <a id="tambah-baru-js" class="btn btn-primary">
                + Tambah Data Baru
            </a>
        </div>

        <div class="mb-5" id="tampil-data"></div>

        <button class="btn btn-success" id="tanah">Kembali ke tanah</button>
        <br><br>
        
    </div>

    <div class="container" id="fuyyoo">
        
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            
            <div class="card-header bg-white text-center py-3">
                <h4 class="mb-0 fw-bold text-primary">Formulir Tambah Peserta</h4>
            </div>

            <div class="card-body p-4">
                
                <form action="" method="POST">
                    
                    <div class="mb-3"> <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukan nama lengkap..." required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-bold">Alamat Domisili</label>
                        <textarea class="form-control" name="alamat" rows="3" placeholder="Masukan alamat lengkap..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="telpon" class="form-label fw-bold">Nomor Telepon</label>
                        <input type="text" class="form-control" name="telpon" placeholder="Contoh: 0812xxxx">
                        <div class="form-text text-muted">Gunakan angka saja.</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Alamat Email</label>
                        <input type="email" class="form-control" name="email" placeholder="nama@email.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Kelas</label>
                        <select name="id_kelas" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Kelas --</option>
                                <?php
                                if (isset($query_kelas)) mysqli_data_seek($query_kelas, 0);
                                while ($kelas = mysqli_fetch_assoc($query_kelas)):
                                ?>
                                <option value="<?php echo $kelas['id_kelas']; ?>"><?php echo $kelas['nama_kelas']; ?></option>
                                <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block">Jenis Kelamin</label>
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="pria" value="Pria" checked>
                                <label class="form-check-label" for="pria">Pria</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="wanita" value="Wanita">
                                <label class="form-check-label" for="wanita">Wanita</label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block">Status Keanggotaan</label>
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="aktif" value="Aktif" checked>
                                <label class="form-check-label" for="aktif">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="nonaktif" value="Tidak aktif">
                                <label class="form-check-label" for="nonaktif">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a id="batal-tambah-baru" class="btn btn-secondary">Batal</a>
                            <button type="submit" name="simpan" class="btn btn-primary px-4">Simpan Data</button>
                        </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#heheyy,#fuyyoo').hide();
        });

        $('#js').on('click', function() {
            $('#eyyo').hide();
            $('#heheyy').show(500);
            tampil_data();
        });

        $('#tanah').on('click', function() {
            $('#eyyo').show(500);
            $('#heheyy').hide();
        });

        $('#tambah-baru-php').on('click', function() {
            $('#fuyyoo').show(500);
        });

        $('#tambah-baru-js').on('click', function() {
            $('#fuyyoo').show(500);
        });

        $('#batal-tambah-baru').on('click', function() {
            $('#fuyyoo').hide(500);
        });

        $('#simpan-data').on('click', function() {
            $('#eyyo').hide();
            $('#heheyy').show(500);
            tampil_data();
        });


        function tampil_data() {
            $.ajax({
                url: 'get_data.php',
                type: 'GET',
                success: function(data) {
                    $('#tampil-data').html(data);
                }
            })
        }
    </script>
    
    <script src="js/bootstrap.bundle.min.js"></script>

</body>