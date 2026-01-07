<nav class="profile-nav bg-gradient-to-r from-purple-700 to-indigo-600 text-white shadow-sm">
    <div class="nav-container max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Brand -->
        <div class="nav-brand text-2xl font-bold flex items-center space-x-2">
            <a href="/dash" class="flex items-center hover:opacity-90">
                <i class="fas fa-tasks"></i>
                <span>TaskTim</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="nav-links flex space-x-6">
            <a href="/dash" class="nav-link font-medium <?= current_url() == base_url('/dash') ? 'underline' : '' ?>">Dashboard</a>
            <a href="/dashboard" class="nav-link font-medium <?= current_url() == base_url('/dashboard') ? 'underline' : '' ?>">Daftar Tugas</a>
            <a href="/profile" class="nav-link font-medium <?= current_url() == base_url('/profile') ? 'underline' : '' ?>">Profile</a>
            <a href="/about" class="nav-link font-medium <?= current_url() == base_url('/about') ? 'underline' : '' ?>">About Us</a>
        </div>

        <!-- User Menu -->
        <?php if (isset($user)): ?>
        <div class="relative user-menu">
            <button id="userMenuBtn" aria-haspopup="true" aria-expanded="false" aria-controls="userMenuDropdown"
                class="flex items-center rounded-full px-3 py-1 focus:outline-none focus:ring-2 focus:ring-white" tabindex="0">
                <img src="<?= esc($user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['nama'])) ?>" 
                     class="rounded-full w-8 h-8 mr-2 object-cover" alt="Avatar">
                <span class="mr-2"><?= esc($user['nama']) ?></span>
                <i class="fas fa-chevron-down text-white text-sm"></i>
            </button>
            <ul id="userMenuDropdown" role="menu" tabindex="-1"
                class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg hidden z-50 transition ease-out duration-150"
                >
                <li role="none">
                    <form action="/logout" method="get" class="m-0" role="menuitem">
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userMenuDropdown = document.getElementById('userMenuDropdown');

    if (!userMenuBtn || !userMenuDropdown) return;

    function closeMenu() {
        userMenuDropdown.classList.add('hidden');
        userMenuBtn.setAttribute('aria-expanded', 'false');
    }

    function openMenu() {
        userMenuDropdown.classList.remove('hidden');
        userMenuBtn.setAttribute('aria-expanded', 'true');
    }

    userMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (userMenuDropdown.classList.contains('hidden')) {
            openMenu();
        } else {
            closeMenu();
        }
    });

    // Close dropdown on click outside
    document.addEventListener('click', (e) => {
        if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
            closeMenu();
        }
    });

    // Optional: close dropdown on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape") {
            closeMenu();
            userMenuBtn.focus();
        }
    });
});
</script>
