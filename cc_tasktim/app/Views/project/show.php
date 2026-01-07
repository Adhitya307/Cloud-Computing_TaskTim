<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Detail Sub-Tugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-100 to-white min-h-screen p-6">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-md">
        
        <!-- Judul -->
        <h1 class="text-3xl font-bold text-indigo-700 mb-4"><?= esc($task['title']) ?></h1>

        <!-- Deskripsi -->
        <section class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Deskripsi</h2>
            <p class="text-gray-700"><?= esc($task['description']) ?: 'Tidak ada deskripsi.' ?></p>
        </section>

        <!-- Status -->
        <section class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Status</h2>
            <span 
                class="inline-block px-3 py-1 text-sm font-medium rounded-full
                    <?= ($task['status'] === 'todo') ? 'bg-indigo-100 text-indigo-800' : 
                       (($task['status'] === 'doing') ? 'bg-yellow-100 text-yellow-800' : 
                       'bg-green-100 text-green-800') ?>">
                <?= ucfirst($task['status']) ?>
            </span>
        </section>

        <!-- Komentar -->
        <section class="border-t pt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Diskusi / Komentar</h2>

            <!-- List komentar -->
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <article class="mb-4 p-4 bg-gray-50 border rounded-lg">
                        <p class="text-sm text-gray-800">
                            <strong><?= esc($comment['nama']) ?>:</strong> <?= esc($comment['comment']) ?>
                        </p>
                        <time class="text-xs text-gray-500 mt-1" datetime="<?= esc($comment['created_at']) ?>">
                            <?= date('d M Y H:i', strtotime($comment['created_at'])) ?>
                        </time>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 mb-4">Belum ada komentar.</p>
            <?php endif; ?>

            <!-- Form komentar -->
            <form action="<?= base_url('comments/store') ?>" method="post" class="mt-6 space-y-4">
                <?= csrf_field() ?>
                <input type="hidden" name="task_id" value="<?= esc($task['id']) ?>" />

                <textarea 
                    name="comment" 
                    rows="3" 
                    class="w-full p-3 border rounded focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Tulis komentar..."
                    required
                ></textarea>
                
                <button 
                    type="submit" 
                    class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition-all"
                >
                    Kirim Komentar
                </button>
            </form>
        </section>

        <!-- Link kembali di bawah -->
        <div class="mt-8">
            <a href="<?= base_url('project/' . $project['id']) ?>" class="text-indigo-600 hover:underline flex items-center gap-1">
                ← Kembali ke proyek
            </a>
        </div>
    </div>
</body>
</html>
