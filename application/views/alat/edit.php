<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Alat Laboratorium</h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('alat/update/'.$alat->id) ?>" method="post">
                <div class="mb-3">
                    <label for="nama_alat" class="form-label">Nama Alat</label>
                    <input type="text" class="form-control" id="nama_alat" name="nama_alat" value="<?= $alat->nama_alat ?>" required>
                    <?= form_error('nama_alat', '<small class="text-danger">', '</small>') ?>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $alat->deskripsi ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" min="1" value="<?= $alat->stok ?>" required>
                    <?= form_error('stok', '<small class="text-danger">', '</small>') ?>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('alat') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>