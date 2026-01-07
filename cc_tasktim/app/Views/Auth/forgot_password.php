<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - TaskTim</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/forgot-password.css">
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-form">
            <h2>Lupa Kata Sandi</h2>
            
<?php if (session()->getFlashdata('error') || session()->getFlashdata('success')): ?>
    <div class="popup-flash <?= session()->getFlashdata('error') ? 'error' : 'success' ?>">
        <div class="popup-content">
            <span class="popup-close" onclick="this.parentElement.parentElement.style.display='none'">&times;</span>
            <?= session()->getFlashdata('error') ?: session()->getFlashdata('success') ?>
        </div>
    </div>
<?php endif; ?>


            <form method="post" action="/forgot-password">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Masukkan Email Anda" required>
                </div>
                
                <button type="submit" class="btn-submit">Kirim Link Reset</button>

                <div class="back-link">
                    <a href="/login">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Auto-hide flash messages after 5 seconds
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