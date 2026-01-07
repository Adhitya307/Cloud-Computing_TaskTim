<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Profil Pengguna - TaskTim<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <h2 class="profile-title">Edit Profil</h2>
            <div class="avatar-upload">
                <div class="avatar-preview">
                    <img src="<?= $user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['nama']) ?>" 
                         alt="Profile Photo" id="avatarPreview">
                </div>
                <button class="upload-button">
                    <i class="fas fa-camera"></i> Ganti Foto
                </button>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="/profile/update" method="post" class="profile-form">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" value="<?= esc($user['nama']) ?>" 
                       class="form-input" placeholder="Masukkan nama lengkap">
            </div>
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" name="email" id="email" value="<?= esc($user['email']) ?>" 
                       class="form-input" placeholder="Masukkan alamat email">
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea name="bio" id="bio" class="form-textarea" 
                          placeholder="Ceritakan sedikit tentang Anda"><?= esc($user['bio'] ?? '') ?></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-button">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/js/profile.js"></script>
<?= $this->endSection() ?>