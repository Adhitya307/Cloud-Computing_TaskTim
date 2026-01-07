<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Projects Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/dash.css">
    <link rel="stylesheet" href="/css/main.css">

</head>
<body>

    <!-- Navbar -->
    <?= $this->include('partials/navbar') ?>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-folder-open mr-2 text-indigo-500"></i> My Projects
        </h1>
    </div>

    <?php if (empty($projects)): ?>
        <div class="empty-state">
            <div class="mx-auto w-24 h-24 text-indigo-400 mb-4">
                <i class="fas fa-folder-open text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No projects yet</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new project.</p>
            <div class="mt-6">
                <a href="/projects/create" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    <i class="fas fa-plus mr-2"></i> New Project
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($projects as $project): ?>
                <div class="project-card rounded-lg hover:shadow-lg">
                    <!-- Project Header with Initial -->
                    <div class="w-full h-32 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center relative rounded-t-lg">
                        <span class="text-white text-3xl font-bold"><?= strtoupper(substr($project['name'], 0, 1)) ?></span>
                        <div class="absolute top-2 right-2">
                            <span class="bg-black/90 text-xs font-medium px-2 py-1 rounded-full text-gray-800">
                                <?= $project['created_at'] ?>
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2"><?= esc($project['name']) ?></h2>

                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Progress</span>
                                <span><?= $project['progress'] ?>%</span>
                            </div>
                            <div class="progress-bar rounded-full">
                                <div class="progress-fill rounded-full" style="width: <?= $project['progress'] ?>%"></div>
                            </div>
                        </div>

                        <!-- Task Counters -->
                        <div class="grid grid-cols-3 gap-2 text-center mb-4">
                            <div class="bg-indigo-50 p-2 rounded">
                                <div class="text-indigo-600 font-medium"><?= count($project['tasks']['todo']) ?></div>
                                <div class="text-xs text-gray-500">To Do</div>
                            </div>
                            <div class="bg-yellow-50 p-2 rounded">
                                <div class="text-yellow-600 font-medium"><?= count($project['tasks']['doing']) ?></div>
                                <div class="text-xs text-gray-500">Doing</div>
                            </div>
                            <div class="bg-green-50 p-2 rounded">
                                <div class="text-green-600 font-medium"><?= count($project['tasks']['done']) ?></div>
                                <div class="text-xs text-gray-500">Done</div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between items-center">
                            <a href="/project/<?= $project['id'] ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                <i class="fas fa-external-link-alt mr-1"></i> Open
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<!-- Flash Message -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg flex items-center animate-fade-in">
        <i class="fas fa-check-circle mr-2"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
    <script>
        setTimeout(() => {
            const flash = document.querySelector('.animate-fade-in');
            if (flash) {
                flash.classList.add('animate-fade-out');
                setTimeout(() => flash.remove(), 500);
            }
        }, 3000);
    </script>
<?php endif; ?>

<?= $this->section('scripts') ?>
<script src="/js/profile.js"></script>
<?= $this->endSection() ?>

</body>
</html>
