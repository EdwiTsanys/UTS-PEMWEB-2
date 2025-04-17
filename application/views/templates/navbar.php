<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
            <?php if ($this->session->userdata('role') == 'mahasiswa'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('booking') ?>">Daftar Alat Peminjaman</a>
                </li>
            <?php elseif ($this->session->userdata('role') == 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('alat') ?>">Kelola Alat</a>
                </li>
            <?php endif; ?>
        </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <?= $this->session->userdata('nama') ?> (<?= $this->session->userdata('nim') ?>)
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>