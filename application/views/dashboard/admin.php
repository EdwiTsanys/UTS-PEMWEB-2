<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mt-4">
    <h2>Dashboard Admin</h2>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Peminjaman</h5>
        </div>
        <div class="card-body">
            <?php if (empty($bookings)): ?>
                <p class="text-muted">Belum ada permintaan peminjaman</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Nama Alat</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?= $booking->nama_mahasiswa ?></td>
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
                                        <span class="badge <?= $badge_class ?>"><?= ucfirst($booking->status) ?></span>
                                    </td>
                                    <td>
                                        <?php if ($booking->status == 'pending'): ?>
                                            <a href="<?= base_url('booking/approve/'.$booking->id) ?>" class="btn btn-sm btn-success">Setujui</a>
                                            <a href="<?= base_url('booking/reject/'.$booking->id) ?>" class="btn btn-sm btn-danger">Tolak</a>
                                        <?php elseif ($booking->status == 'disetujui'): ?>
                                            <a href="<?= base_url('booking/complete/'.$booking->id) ?>" class="btn btn-sm btn-info">Selesai</a>
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