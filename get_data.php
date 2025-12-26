<?php

require_once 'config.php';

$sql = 'SELECT a.*, k.nama_kelas FROM anggota as a
        LEFT JOIN kelas as k ON a.id_kelas = k.id_kelas
        GROUP BY a.id_anggota
        ORDER BY a.id_anggota ASC';

$query = mysqli_query($conn, $sql);

if (!$query) {
    die('SQL error: ' . mysqli_error($conn));
};

?>

<div class="card shadow-sm">
    
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