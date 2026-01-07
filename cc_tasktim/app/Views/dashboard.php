<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - TaskTim</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap 5.3.0 stable CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <!-- CSS Lokal -->
    <link rel="stylesheet" href="<?= esc(base_url('/css/dashboard.css')) ?>">
    <link rel="stylesheet" href="<?= esc(base_url('/css/main.css')) ?>">
</head>
<body>
<nav class="profile-nav bg-gradient-to-r from-purple-700 to-indigo-600 text-white shadow-sm">
    <div class="nav-container max-w-7xl mx-auto px-4 py-3 d-flex justify-content-between align-items-center">
        <!-- Brand -->
        <div class="nav-brand text-2xl font-bold d-flex align-items-center gap-2">
            <a href="<?= esc(base_url('/dash')) ?>" class="d-flex align-items-center text-white text-decoration-none opacity-90-hover">
                <i class="fas fa-tasks"></i>
                <span>TaskTim</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="nav-links d-flex gap-4">
            <?php 
                $path = current_url(true)->getPath(); // Ambil path URL saat ini, contoh: dash, dashboard
            ?>
            <a href="<?= esc(base_url('/dash')) ?>" class="nav-link font-medium <?= $path === 'dash' ? 'text-decoration-underline' : '' ?> text-white">Dashboard</a>
            <a href="<?= esc(base_url('/dashboard')) ?>" class="nav-link font-medium <?= $path === 'dashboard' ? 'text-decoration-underline' : '' ?> text-white">Daftar Tugas</a>
            <a href="<?= esc(base_url('/profile')) ?>" class="nav-link font-medium <?= $path === 'profile' ? 'text-decoration-underline' : '' ?> text-white">Profile</a>
            <a href="<?= esc(base_url('/about')) ?>" class="nav-link font-medium <?= $path === 'about' ? 'text-decoration-underline' : '' ?> text-white">About Us</a>
        </div>

        <!-- User Menu -->
        <?php if (isset($user)): ?>
<div class="dropdown">
  <button class="btn btn-link dropdown-toggle text-white d-flex align-items-center gap-2 p-1 rounded-circle" 
          type="button" id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
    <img src="<?= esc($user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['nama'])) ?>" 
         class="rounded-circle" style="width:32px; height:32px; object-fit:cover;" alt="Avatar">
    <span class="me-2"><?= esc($user['nama']) ?></span>
  </button>
  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuBtn">
    <li>
      <form action="<?= esc(base_url('/logout')) ?>" method="post" class="m-0">
        <?= csrf_field() ?>
        <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
    </li>
  </ul>
</div>

        <?php endif; ?>
    </div>
</nav>

<!-- Background Dekorasi -->
<div class="bg-decor">
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>
</div>

<!-- Konten Utama -->
<div class="container mt-5 animate-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="fas fa-folder-open me-2 text-gold"></i> Project Saya
        </h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProjectModal">
            <i class="fas fa-plus me-2"></i> Buat Project
        </button>
    </div>

    <?php if (empty($projects)): ?>
        <div class="alert alert-info text-center py-4" style="background: rgba(15, 5, 36, 0.7); border-left: 4px solid var(--gold-accent);">
            <i class="fas fa-folder-open fa-3x mb-3 text-gold"></i>
            <h4>Belum ada project</h4>
            <p class="mb-0">Silakan buat project baru untuk memulai</p>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($projects as $project): ?>
                <div class="col">
                    <div class="card card-project h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><?= esc($project['name']) ?></h5>
                        </div>
                        <div class="card-body text-center">
                            <i class="fas fa-project-diagram fa-3x mb-3 text-gold"></i>
                        </div>
                        <div class="card-footer bg-transparent d-grid gap-2">
                            <a href="<?= esc(base_url('/projects/' . $project['id'] . '/members')) ?>" class="btn btn-outline-primary">
                                <i class="fas fa-users me-2"></i> Anggota
                            </a>
                            <a href="<?= esc(base_url('project/' . $project['id'])) ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-search me-2"></i> Detail
                            </a>
                            <?php if (isset($project['role']) && $project['role'] === 'ketua'): ?>
                                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editProjectModal<?= esc($project['id']) ?>">
                                    <i class="fas fa-edit me-2"></i> Edit
                                </button>
                                <form action="<?= esc(base_url('/projects/delete')) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');" class="d-grid m-0">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= esc($project['id']) ?>">
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-trash me-2"></i> Hapus
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Proyek -->
                <?php if (isset($project['role']) && $project['role'] === 'ketua'): ?>
                    <div class="modal fade" id="editProjectModal<?= esc($project['id']) ?>" tabindex="-1" aria-labelledby="editProjectModalLabel<?= esc($project['id']) ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="<?= esc(base_url('/projects/update')) ?>" method="post" class="modal-content needs-validation" novalidate>
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProjectModalLabel<?= esc($project['id']) ?>">Edit Nama Proyek</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= esc($project['id']) ?>">
                                    <div class="mb-3">
                                        <label for="projectName<?= esc($project['id']) ?>" class="form-label">Nama Proyek</label>
                                        <input type="text" class="form-control bg-dark text-white border-dark" id="projectName<?= esc($project['id']) ?>" name="name" value="<?= esc($project['name']) ?>" required>
                                        <div class="invalid-feedback">Nama proyek wajib diisi.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Buat Project -->
<div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= esc(base_url('/projects/create')) ?>" method="post" class="modal-content needs-validation" novalidate>
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title" id="createProjectModalLabel">Buat Project Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="projectName" class="form-label">Nama Project</label>
                    <input type="text" class="form-control bg-dark text-white border-dark" id="projectName" name="name" required placeholder="Masukkan nama project" />
                    <div class="invalid-feedback">Nama project wajib diisi.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Buat Project</button>
            </div>
        </form>
    </div>
</div>

<!-- Flash Message -->
<?php if (session()->getFlashdata('success') || session()->getFlashdata('error')): ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header" style="background: linear-gradient(135deg, var(--royal-purple), var(--deep-blue)); color: white; border-left: 4px solid var(--gold-accent);">
                <strong class="me-auto">
                    <?= session()->getFlashdata('success') ? 'Sukses' : 'Error' ?>
                </strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Tutup"></button>
            </div>
            <div class="toast-body" style="background: rgba(15, 5, 36, 0.9);">
                <?= esc(session()->getFlashdata('success') ?: session()->getFlashdata('error')) ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Script Bootstrap & Flash -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle toast
    const toastEl = document.querySelector('.toast');
    if (toastEl) {
        const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
        setTimeout(() => toast.hide(), 5000);
    }

    // Tooltip initialization
    const tooltips = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltips.forEach(el => new bootstrap.Tooltip(el));

    // User menu toggle with aria-expanded update
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userMenuDropdown = document.getElementById('userMenuDropdown');
    if (userMenuBtn && userMenuDropdown) {
        userMenuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isHidden = userMenuDropdown.classList.contains('d-none');
            userMenuDropdown.classList.toggle('d-none');
            userMenuBtn.setAttribute('aria-expanded', String(!isHidden));
        });
        document.addEventListener('click', function (e) {
            if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                userMenuDropdown.classList.add('d-none');
                userMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // Bootstrap form validation
    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
});
</script>
</body>
</html>
