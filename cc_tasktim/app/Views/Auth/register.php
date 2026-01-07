<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - TaskTim</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/register.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                    <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                    <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
                </div>
            <?php endif; ?>

            <div class="logo">
                <h2>Daftar Akun TaskTim</h2>
            </div>
            
            <div class="team-illustration">
                <svg width="150" height="120" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M402 168c-2.7 0-5.4.1-8 .3-7.1-27.9-32.2-48.3-62-48.3-12.3 0-23.9 3.2-34 8.8-14.3-18.8-37-31.2-62.4-31.2-15.9 0-30.7 5-42.9 13.5-8.3-5.5-18.1-8.7-28.7-8.7-30.9 0-56 25.1-56 56 0 2.3.1 4.6.3 6.8C59.8 184.1 32 214.1 32 250.4c0 36.4 29.6 66.1 66.1 66.1h307.8c36.4 0 66.1-29.6 66.1-66.1 0-36.3-27.8-66.3-63.9-66.3z" fill="#e0e7ff"/>
                    <path d="M256 288c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96z" fill="#a5b4fc"/>
                    <path d="M256 288c-53 0-96-43-96-96s43-96 96-96v192z" fill="#818cf8"/>
                    <path d="M256 352c-88.4 0-160 71.6-160 160h320c0-88.4-71.6-160-160-160z" fill="#a5b4fc"/>
                    <path d="M256 352v160h160c0-88.4-71.6-160-160-160z" fill="#818cf8"/>
                    <circle cx="256" cy="192" r="96" fill="#c7d2fe"/>
                </svg>
            </div>

            <form method="post" action="/register">
                <div class="form-group">
                    <input type="text" class="form-input <?= session()->getFlashdata('errors.nama') ? 'input-error' : '' ?>" 
                           name="nama" placeholder="Nama Lengkap" 
                           value="<?= old('nama') ?>" required>
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" 
                           class="form-input <?= session()->getFlashdata('errors.email') ? 'input-error' : '' ?>" 
                           placeholder="Email" 
                           value="<?= old('email') ?>" required>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" 
                           class="form-input <?= session()->getFlashdata('errors.password') ? 'input-error' : '' ?>" 
                           placeholder="Kata Sandi" required>
                </div>

                <button type="submit" class="btn">Daftar Sekarang</button>

                <div class="login-link">
                    Sudah punya akun? <a href="/login">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>