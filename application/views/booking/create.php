<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mt-4">
    <h2>Form Peminjaman Alat</h2>
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><?= $alat->nama_alat ?></h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('booking/store') ?>" method="post">
                <input type="hidden" name="alat_id" value="<?= $alat->id ?>">
                
                <div class="mb-3">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required min="<?= date('Y-m-d') ?>">
                </div>
                
                <div class="mb-3">
                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required min="<?= date('Y-m-d') ?>">
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?= base_url('booking') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>