<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tentang Kami - TaskTim</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('/css/about.css') ?>" />
    <style>
        /* Navbar Container */
        .profile-nav {
            background: linear-gradient(to right, #6b21a8, #4f46e5); /* from-purple-700 to-indigo-600 */
            color: #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 50;
        }

        /* Navbar inner layout */
        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Brand */
        .nav-brand a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #fff;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Nav links */
        .nav-links {
            display: flex;
            gap: 1.25rem;
        }

        .nav-link {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            transition: opacity 0.2s ease;
        }

        .nav-link:hover {
            opacity: 0.8;
        }

        .text-decoration-underline {
            text-decoration: underline;
        }

        /* Dropdown basic styling */
        .dropdown .btn {
            background: transparent;
            border: none;
            font-weight: 500;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .dropdown-menu {
            min-width: 180px;
            font-size: 0.95rem;
            background: #fff;
            border: 1px solid #ccc;
            margin-top: 0.5rem;
            border-radius: 0.375rem;
            padding: 0.25rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            position: absolute;
            right: 0;
            z-index: 100;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item.text-danger {
            color: #dc3545;
        }

        .rounded-circle {
            border-radius: 50%;
        }
    </style>
</head>
<body class="about-page">
<nav class="profile-nav">
    <div class="nav-container max-w-7xl mx-auto px-4 py-3">
        <!-- Brand -->
        <div class="nav-brand">
            <a href="<?= esc(base_url('/dash')) ?>" class="hover:opacity-90">
                <i class="fas fa-tasks"></i>
                <span>TaskTim</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="nav-links">
            <?php 
                $path = current_url(true)->getPath();
            ?>
            <a href="<?= esc(base_url('/dash')) ?>" class="nav-link <?= $path === 'dash' ? 'text-decoration-underline' : '' ?>">Dashboard</a>
            <a href="<?= esc(base_url('/dashboard')) ?>" class="nav-link <?= $path === 'dashboard' ? 'text-decoration-underline' : '' ?>">Daftar Tugas</a>
            <a href="<?= esc(base_url('/profile')) ?>" class="nav-link <?= $path === 'profile' ? 'text-decoration-underline' : '' ?>">Profile</a>
            <a href="<?= esc(base_url('/about')) ?>" class="nav-link <?= $path === 'about' ? 'text-decoration-underline' : '' ?>">About Us</a>
        </div>

<?php if (isset($user)): ?>
<div class="flex items-center gap-4 text-white">
    <form action="<?= esc(base_url('/logout')) ?>" method="post" class="m-0">
        <?= csrf_field() ?>
        <button type="submit" 
                class="flex items-center gap-1 text-red-500 hover:text-red-600 focus:outline-none" 
                aria-label="Logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>
<?php endif; ?>

    </div>
</nav>

<!-- Hero Section -->
<header class="about-hero flex flex-col md:flex-row items-center max-w-7xl mx-auto px-4 py-12 gap-8">
    <div class="hero-content flex-1">
        <h1 class="hero-title text-4xl font-bold mb-4">Tentang TaskTim</h1>
        <p class="hero-subtitle text-lg mb-6">Mengubah cara tim Anda bekerja, berkolaborasi, dan mencapai tujuan</p>
        <div class="hero-stats flex gap-8 text-center text-purple-700">
            <div>
                <span class="stat-number text-3xl font-extrabold">10K+</span>
                <span class="stat-label block mt-1 font-semibold">Pengguna</span>
            </div>
            <div>
                <span class="stat-number text-3xl font-extrabold">50K+</span>
                <span class="stat-label block mt-1 font-semibold">Proyek</span>
            </div>
            <div>
                <span class="stat-number text-3xl font-extrabold">100%</span>
                <span class="stat-label block mt-1 font-semibold">Kepuasan</span>
            </div>
        </div>
    </div>
    <div class="hero-image flex-1">
        <img src="<?= base_url('/uploads/1.jpg') ?>" alt="Team Collaboration" class="w-full rounded-lg shadow-lg" />
    </div>
</header>

<!-- Our Story Section -->
<section class="about-story max-w-7xl mx-auto px-4 py-12 flex flex-col md:flex-row items-center gap-12">

    <div class="story-content flex-1">
        <h2 class="section-title text-3xl font-bold mb-4">Cerita Kami</h2>
        <p class="story-text mb-6 text-gray-700 leading-relaxed">
            TaskTim lahir dari pengalaman pribadi kami dalam menghadapi tantangan manajemen proyek tim. 
            Didirikan pada tahun 2020, kami berkomitmen untuk menciptakan solusi yang sederhana namun 
            powerful untuk membantu tim bekerja lebih efektif.
        </p>
        <div class="story-highlights flex gap-8">
            <div class="highlight-item flex flex-col items-center text-purple-700">
                <i class="fas fa-lightbulb text-4xl mb-2"></i>
                <h3 class="font-semibold text-xl">Visi</h3>
                <p class="text-center max-w-xs">Menciptakan alat kolaborasi yang intuitif untuk semua tim</p>
            </div>
            <div class="highlight-item flex flex-col items-center text-purple-700">
                <i class="fas fa-bullseye text-4xl mb-2"></i>
                <h3 class="font-semibold text-xl">Misi</h3>
                <p class="text-center max-w-xs">Menyederhanakan manajemen tugas tanpa mengurangi fungsionalitas</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="about-features max-w-7xl mx-auto px-4 py-12">
    <h2 class="section-title text-center text-3xl font-bold mb-8">Kenapa Memilih TaskTim?</h2>
    <div class="features-grid grid grid-cols-1 md:grid-cols-4 gap-8 text-center text-gray-700">
        <div class="feature-card p-6 border rounded-lg shadow hover:shadow-lg transition">
            <div class="feature-icon mb-4 text-purple-700 text-4xl"><i class="fas fa-users"></i></div>
            <h3 class="font-semibold mb-2 text-xl">Kolaborasi Tim</h3>
            <p>Kelola anggota tim dan tugas dengan mudah dalam satu platform terintegrasi</p>
        </div>
        <div class="feature-card p-6 border rounded-lg shadow hover:shadow-lg transition">
            <div class="feature-icon mb-4 text-purple-700 text-4xl"><i class="fas fa-tasks"></i></div>
            <h3 class="font-semibold mb-2 text-xl">Manajemen Tugas</h3>
            <p>Buat, pantau, dan selesaikan tugas dengan sistem yang terorganisir</p>
        </div>
        <div class="feature-card p-6 border rounded-lg shadow hover:shadow-lg transition">
            <div class="feature-icon mb-4 text-purple-700 text-4xl"><i class="fas fa-chart-line"></i></div>
            <h3 class="font-semibold mb-2 text-xl">Analitik Proyek</h3>
            <p>Dapatkan insight tentang performa tim dan progres proyek</p>
        </div>
        <div class="feature-card p-6 border rounded-lg shadow hover:shadow-lg transition">
            <div class="feature-icon mb-4 text-purple-700 text-4xl"><i class="fas fa-mobile-alt"></i></div>
            <h3 class="font-semibold mb-2 text-xl">Akses Multi-Device</h3>
            <p>Gunakan TaskTim di desktop, tablet, atau smartphone Anda</p>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="about-team max-w-7xl mx-auto px-4 py-12">
    <h2 class="section-title text-center text-3xl font-bold mb-2">Tim Kami</h2>
    <p class="section-subtitle text-center text-gray-600 mb-8">Orang-orang berbakat di balik kesuksesan TaskTim</p>
    
    <div class="team-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <?php foreach ($team as $member): ?>
        <div class="team-card perspective group">
            <div class="team-card-inner relative w-full h-72 transition-transform duration-500 transform-style-preserve-3d group-hover:rotate-y-180">
                <!-- Front -->
                <div class="team-card-front absolute w-full h-full backface-hidden rounded-lg overflow-hidden shadow-lg flex flex-col items-center justify-center bg-white p-6">
                    <img src="<?= esc($member['foto']) ?>" alt="<?= esc($member['nama']) ?>" class="team-photo rounded-full w-24 h-24 object-cover mb-4" />
                    <h3 class="team-name font-semibold text-lg"><?= esc($member['nama']) ?></h3>
                    <p class="team-position text-gray-500"><?= esc($member['jabatan']) ?></p>
                </div>
                <!-- Back -->
                <div class="team-card-back absolute w-full h-full backface-hidden rotate-y-180 rounded-lg overflow-hidden shadow-lg bg-purple-600 text-white p-6 flex flex-col justify-center items-center text-center">
                    <p class="team-bio text-sm"><?= esc($member['bio']) ?></p>
                    <div class="team-social mt-4 flex gap-4">
                        <?php if (!empty($member['linkedin'])): ?>
                            <a href="<?= esc($member['linkedin']) ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn <?= esc($member['nama']) ?>">
                                <i class="fab fa-linkedin fa-lg"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($member['twitter'])): ?>
                            <a href="<?= esc($member['twitter']) ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter <?= esc($member['nama']) ?>">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($member['github'])): ?>
                            <a href="<?= esc($member['github']) ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub <?= esc($member['nama']) ?>">
                                <i class="fab fa-github fa-lg"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>


<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 py-8 text-center text-sm">
    <p>&copy; <?= date('Y') ?> TaskTim. Semua hak cipta dilindungi.</p>
</footer>


</body>
</html>
