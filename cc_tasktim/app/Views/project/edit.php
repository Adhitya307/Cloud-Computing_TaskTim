<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(to bottom right, #2c2c54, #474787);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        background-color: #ffffff10;
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.4);
        padding: 30px;
        color: #fff;
    }

    .form-label {
        font-weight: 600;
        color: #fcd34d;
    }

    .form-control, .form-select {
        background-color: #f1f1f120;
        border: 1px solid #888;
        color: #fff;
    }

    .form-control:focus, .form-select:focus {
        border-color: #fcd34d;
        box-shadow: 0 0 0 0.25rem rgba(252, 211, 77, 0.25);
    }

    .btn-primary {
        background-color: #6366f1;
        border: none;
    }

    .btn-primary:hover {
        background-color: #4f46e5;
    }

    .btn-secondary {
        background-color: #6b7280;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    h1 {
        text-align: center;
        color: #fef9c3;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
    }
</style>

<div class="container mt-5" style="max-width: 600px;">
    <h1 class="mb-4">✏️ Edit Task</h1>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="<?= base_url("task/{$task['id']}/update") ?>" method="post" novalidate>
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="title" class="form-label">📝 Judul Task</label>
            <input
                type="text"
                class="form-control"
                id="title"
                name="title"
                value="<?= set_value('title', $task['title']) ?>"
                required
                minlength="3"
            >
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">🧾 Deskripsi</label>
            <textarea
                class="form-control"
                id="description"
                name="description"
                rows="4"
            ><?= set_value('description', $task['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">📊 Status</label>
            <select
                class="form-select"
                id="status"
                name="status"
                required
            >
                <option value="todo" <?= set_value('status', $task['status']) == 'todo' ? 'selected' : '' ?>>🟦 To Do</option>
                <option value="doing" <?= set_value('status', $task['status']) == 'doing' ? 'selected' : '' ?>>🟨 Doing</option>
                <option value="done" <?= set_value('status', $task['status']) == 'done' ? 'selected' : '' ?>>🟩 Done</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">💾 Update Task</button>
        <a href="<?= base_url("project/{$task['project_id']}") ?>" class="btn btn-secondary ms-2">❌ Batal</a>
    </form>
</div>
