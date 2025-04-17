<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mt-4">
    <h2>Daftar Alat Laboratorium</h2>
    
    <div class="row mt-4">
        <?php foreach ($alat as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= $item->nama_alat ?></h5>
                        <p class="card-text"><?= $item->deskripsi ?></p>
                        <p class="card-text"><strong>Stok Tersedia:</strong> 
                            <span class="<?= $item->stok <= 0 ? 'text-danger' : 'text-success' ?>">
                                <?= $item->stok ?>
                            </span>
                        </p>
                        <a href="<?= base_url('booking/create/'.$item->id) ?>" class="btn btn-primary">Pinjam</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>