<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Detail Proyek - <?= esc($project['name']) ?></title>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Link tema royal gelap -->
    <link href="/css/detail1.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('/css/main.css') ?>">

</head>
<body>

        <!-- Navbar -->
    <?= $this->include('partials/navbar') ?>

<main class="px-8 py-12 max-w-7xl mx-auto">
    <h1 class="text-4xl font-extrabold text-indigo-700 mb-10 text-center drop-shadow-lg">
        <?= esc($project['name']) ?>
        <?php if (session()->has('errors')): ?>
    <div class="bg-red-100 p-4 text-red-600 rounded">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
        <?php
        $statuses = [
            'todo' => ['label' => 'To Do', 'color' => 'indigo-500'],
            'doing' => ['label' => 'Doing', 'color' => 'yellow-400'],
            'done' => ['label' => 'Done', 'color' => 'green-500'],
        ];

        foreach ($statuses as $status => $info):
            $borderClass = "border-t-4 border-{$info['color']}";
        ?>
        <section>
            <div class="p-6 bg-white shadow-xl rounded-xl <?= $borderClass ?>">
                <h3 class="text-xl font-bold mb-4"><?= $info['label'] ?></h3>
                <ul id="list-<?= $status ?>" class="task-list space-y-4 min-h-[100px]" data-status="<?= $status ?>">
                    <?php foreach ($tasks[$status] as $task): ?>
                    <li class="task-item bg-gray-100 p-4 rounded-lg border-l-4 border-indigo-400 cursor-move" data-id="<?= $task['id'] ?>">
                        <div class="flex justify-between items-center">
                            <a href="<?= base_url('task/' . $task['id']) ?>" class="font-semibold">
                                <?= esc($task['title']) ?>
                            </a>
                            <div class="flex gap-2">
                                <button class="btn-edit text-indigo-600 hover:text-indigo-900" data-id="<?= $task['id'] ?>">
                                    ✏️
                                </button>
                                <form method="POST" action="<?= base_url('task/' . $task['id']) ?>" class="delete-form" onsubmit="return confirmDelete(event)">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="text-red-600 hover:text-red-900">🗑️</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
        <?php endforeach; ?>
    </div>

    <div class="mt-12 flex justify-between">
        <a href="/dashboard" class="btn-indigo bg-gray-500 hover:bg-gray-600">← Kembali</a>
        <button class="btn-indigo" onclick="openModalTambah()">Tambah Sub-Tugas</button>
    </div>
</main>
<?php if (session()->has('errors')): ?>
    <div class="bg-red-100 p-4 text-red-600 rounded mb-4">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


<!-- Modal Tambah Sub-Tugas -->
<div id="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-indigo-600 mb-4 text-center">Tambah Sub-Tugas</h2>
        <form action="<?= base_url('project/' . $project['id'] . '/task/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            <div>
                <label for="title">Judul Sub-Tugas</label>
                <input type="text" name="title" id="title" class="mt-1 w-full border px-3 py-2 rounded" required />
            </div>
            <div>
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" class="mt-1 w-full border px-3 py-2 rounded"></textarea>
            </div>
            <div>
                <label for="status">Status</label>
                <select name="status" id="status" class="mt-1 w-full border px-3 py-2 rounded">
                    <option value="todo">To Do</option>
                    <option value="doing">Doing</option>
                    <option value="done">Done</option>
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModalTambah()" class="btn-indigo bg-gray-400 hover:bg-gray-500">Batal</button>
                <button type="submit" class="btn-indigo">Tambah</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
    function openModalTambah() {
        document.getElementById('modalTambah').classList.remove('hidden');
    }

    function closeModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
    }

    function confirmDelete(event) {
        event.preventDefault();
        const form = event.target;
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }

    // Edit tombol redirect
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            window.location.href = `/task/${id}/edit`;
        });
    });

    // SortableJS Setup
    const statuses = ['todo', 'doing', 'done'];
    statuses.forEach(status => {
        const el = document.getElementById(`list-${status}`);
        new Sortable(el, {
            group: 'tasks',
            animation: 150,
            onAdd: function (evt) {
                const taskId = evt.item.getAttribute('data-id');
                const newStatus = evt.to.getAttribute('data-status');

                fetch('<?= site_url('project/update-status') ?>', {

                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    body: JSON.stringify({ task_id: taskId, status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        Swal.fire("Gagal", data.message || "Gagal memperbarui status", "error");
                    }
                })
                .catch(() => {
                    Swal.fire("Error", "Terjadi kesalahan saat memperbarui status", "error");
                });
            }
        });
    });

    // ESC key close modal
    document.addEventListener('keydown', e => {
        if (e.key === "Escape") closeModalTambah();
    });
</script>

<!-- Flash success -->
<?php if (session()->getFlashdata('success')): ?>
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: "<?= esc(session()->getFlashdata('success')) ?>",
        icon: 'success',
        confirmButtonColor: '#4f46e5',
        confirmButtonText: 'OK'
    });
</script>
<?php endif; ?>

</body>
</html>
