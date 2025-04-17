<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mt-4">
    <h2>Dashboard Mahasiswa</h2>
    <p class="text-muted">Selamat datang, <?= $this->session->userdata('nama') ?></p>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">History Peminjaman Anda</h5>
                <a href="<?= base_url('booking') ?>" class="btn btn-light btn-sm">
                    <i class="bi bi-plus"></i> Buat Peminjaman Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($bookings)): ?>
                <div class="text-center py-4">
                    <i class="bi bi-clipboard-x" style="font-size: 3rem; color: #6c757d;"></i>
                    <p class="mt-3">Belum ada riwayat peminjaman</p>
                    <a href="<?= base_url('booking') ?>" class="btn btn-primary mt-2">
                        Pinjam Alat Sekarang
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Alat</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $booking->nama_alat ?></td>
                                <td><?= date('d/m/Y', strtotime($booking->tanggal_pinjam)) ?></td>
                                <td><?= date('d/m/Y', strtotime($booking->tanggal_kembali)) ?></td>
                                <td>
                                    <?php 
                                        $badge_class = 'bg-secondary';
                                        if ($booking->status == 'disetujui') $badge_class = 'bg-success';
                                        elseif ($booking->status == 'ditolak') $badge_class = 'bg-danger';
                                        elseif ($booking->status == 'selesai') $badge_class = 'bg-info';
                                    ?>
                                    <span class="badge <?= $badge_class ?>">
                                        <?= ucfirst($booking->status) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($booking->status == 'pending'): ?>
                                        <span class="text-warning">Menunggu persetujuan admin</span>
                                    <?php elseif ($booking->status == 'ditolak'): ?>
                                        <span class="text-danger">Peminjaman tidak disetujui</span>
                                    <?php elseif ($booking->status == 'disetujui'): ?>
                                        <span class="text-success">Silakan ambil alat di lab</span>
                                    <?php else: ?>
                                        <span class="text-muted">Peminjaman selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>