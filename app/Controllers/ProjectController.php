<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\ProjectMemberModel;
use App\Models\UserModel;
use App\Models\ProjectTaskModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class ProjectController extends BaseController
{
    protected ProjectModel $projectModel;
    protected ProjectMemberModel $projectMemberModel;
    protected UserModel $userModel;
    protected ProjectTaskModel $taskModel;

    public function __construct()
    {
        $this->projectModel       = new ProjectModel();
        $this->projectMemberModel = new ProjectMemberModel();
        $this->userModel          = new UserModel();
        $this->taskModel          = new ProjectTaskModel();
    }

    /**
     * Detail project dan task berdasarkan status (todo, doing, done)
     */
    public function detail(int $id): string
    {
        $project = $this->projectModel->find($id);

        if (!$project) {
            throw PageNotFoundException::forPageNotFound("Proyek dengan ID $id tidak ditemukan.");
        }

        $allTasks = $this->taskModel->where('project_id', $id)->findAll();

        $tasks = [
            'todo'  => [],
            'doing' => [],
            'done'  => [],
        ];

        foreach ($allTasks as $task) {
            $status = $task['status'] ?? null;
            if ($status && isset($tasks[$status])) {
                $tasks[$status][] = $task;
            }
        }

    $user = session()->get('user'); // ambil data user dari session (pastikan sudah login
    return view('project/detail', [
        'user' => $user,
        'project' => $project,
        'tasks' => $tasks,
    ]);
    }

    /**
     * Undang anggota baru ke project berdasarkan email
     */
    public function inviteMember(): ResponseInterface
    {
        $email     = $this->request->getPost('email');
        $projectId = (int) $this->request->getPost('project_id');

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Email tidak valid.');
        }

        $user = $this->userModel->where('email', $email)->first();

if (!$user) {
    // Simpan email yang diketik ke session agar modal bisa muncul
    return redirect()->back()
        ->with('error', 'Email belum terdaftar. Silakan mendaftar terlebih dahulu.')
        ->with('undangan_email', $email)
        ->withInput();
}

        // Cek apakah user sudah menjadi anggota project
        $isMember = $this->projectMemberModel
            ->where('project_id', $projectId)
            ->where('user_id', $user['id'])
            ->first();

        if ($isMember) {
            return redirect()->back()->with('error', 'User sudah menjadi anggota project ini.');
        }

        // Insert anggota baru
        $this->projectMemberModel->insert([
            'project_id' => $projectId,
            'user_id'    => $user['id'],
            'role'       => 'anggota',
            'invited_at' => Time::now()->toDateTimeString(),
            'status'     => 'active',
        ]);

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan!');
    }

    /**
     * Buat project baru dan assign user sebagai ketua
     */
    public function create(): ResponseInterface
    {
        $user = session()->get('user');

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $projectName = trim($this->request->getPost('name'));

        if (!$projectName) {
            return redirect()->to('/dashboard')->with('error', 'Nama project harus diisi!');
        }

        // Validasi duplicate project name jika perlu
        $existing = $this->projectModel->where('name', $projectName)->first();
        if ($existing) {
            return redirect()->to('/dashboard')->with('error', 'Nama project sudah digunakan.');
        }

        $projectId = $this->projectModel->insert(['name' => $projectName]);

        if (!$projectId) {
            return redirect()->to('/dashboard')->with('error', 'Gagal membuat project.');
        }

        $this->projectMemberModel->insert([
            'project_id' => $projectId,
            'user_id'    => $user['id'],
            'role'       => 'ketua',
            'status'     => 'active',
        ]);

        return redirect()->to('/dashboard')->with('success', 'Project berhasil dibuat!');
    }

    /**
     * Update nama project
     */
    public function update(): ResponseInterface
    {
        $id   = (int) $this->request->getPost('id');
        $name = trim($this->request->getPost('name'));

        if (!$id || !$name) {
            return redirect()->to('/dashboard')->with('error', 'ID dan nama proyek harus diisi!');
        }

        $project = $this->projectModel->find($id);
        if (!$project) {
            return redirect()->to('/dashboard')->with('error', 'Proyek tidak ditemukan.');
        }

        $this->projectModel->update($id, ['name' => $name]);

        return redirect()->to('/dashboard')->with('success', 'Nama proyek berhasil diperbarui.');
    }

    /**
     * Hapus project beserta relasi terkait (optional: gunakan transaksi)
     */
    public function delete(): ResponseInterface
    {
        $id = (int) $this->request->getPost('id');

        if (!$id) {
            return redirect()->to('/dashboard')->with('error', 'ID proyek harus diisi!');
        }

        $project = $this->projectModel->find($id);
        if (!$project) {
            return redirect()->to('/dashboard')->with('error', 'Proyek tidak ditemukan.');
        }

        // Bisa ditambahkan: hapus tugas dan anggota project dalam transaksi

        $this->projectModel->delete($id);

        return redirect()->to('/dashboard')->with('success', 'Proyek berhasil dihapus.');
    }

    /**
     * Form tambah task baru pada project
     */
    public function createTask(int $projectId): string
    {
        $project = $this->projectModel->find($projectId);

        if (!$project) {
            throw PageNotFoundException::forPageNotFound("Proyek tidak ditemukan.");
        }

        return view('project/create_task', ['project' => $project]);
    }

    /**
     * Simpan task baru
     */
public function storeTask(int $projectId): ResponseInterface
{
    $project = $this->projectModel->find($projectId);

    if (!$project) {
        throw PageNotFoundException::forPageNotFound("Proyek tidak ditemukan.");
    }

    $validationRules = [
        'title'  => 'required|min_length[3]',
        'status' => 'required|in_list[todo,doing,done]',
    ];

    if (!$this->validate($validationRules)) {
        return redirect()
            ->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $data = [
        'project_id'  => $projectId,
        'title'       => $this->request->getPost('title'),
        'description' => $this->request->getPost('description'),
        'status'      => $this->request->getPost('status'),
    ];

    // Simpan data
    if (!$this->taskModel->save($data)) {
        return redirect()
            ->back()
            ->withInput()
            ->with('errors', ['general' => 'Gagal menyimpan sub-tugas. Silakan coba lagi.']);
    }

    return redirect()
        ->to(base_url("project/$projectId"))
        ->with('success', 'Sub-tugas berhasil dibuat!');
}

    /**
     * Tampilkan detail task
     */
public function showTask(int $taskId): string
{
    $task = $this->taskModel->find($taskId);
    if (!$task) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tugas tidak ditemukan.");
    }

    $project = $this->projectModel->find($task['project_id']);

    $commentModel = new \App\Models\CommentModel();
    $userModel = new \App\Models\UserModel();

    // Ambil semua komentar terkait task
    $comments = $commentModel->where('task_id', $taskId)->orderBy('created_at', 'ASC')->findAll();

    // Ambil user_id dari komentar, tapi cek dulu kalau $comments kosong
    $userIds = !empty($comments) ? array_column($comments, 'user_id') : [];

    // Ambil data user jika ada user_id
    $users = !empty($userIds) ? $userModel->whereIn('id', $userIds)->findAll() : [];

    // Buat mapping user_id ke nama user
    $userMap = [];
    foreach ($users as $u) {
        $userMap[$u['id']] = $u['nama'];
    }

    // Tambahkan nama user ke setiap komentar, jika user tidak ditemukan beri 'Unknown'
    foreach ($comments as &$comment) {
        $comment['nama'] = $userMap[$comment['user_id']] ?? 'Unknown';
    }
    unset($comment); // Melepaskan reference

    return view('project/show', [
        'task'     => $task,
        'project'  => $project,
        'comments' => $comments,
    ]);
}

    /**
     * Tampilkan anggota project dengan nama user
     */
    public function showProjectMembers(int $projectId): string
    {
        $members = $this->projectMemberModel->getMembersByProject($projectId);

        // Tambahkan nama user ke setiap member secara efisien
        $userIds = array_column($members, 'user_id');
        $users   = $this->userModel->whereIn('id', $userIds)->findAll();
        $usersById = [];
        foreach ($users as $user) {
            $usersById[$user['id']] = $user;
        }

        foreach ($members as &$member) {
            $member['nama'] = $usersById[$member['user_id']]['nama'] ?? 'Unknown';
        }

        $project = $this->projectModel->find($projectId);

        if (!$project) {
            throw PageNotFoundException::forPageNotFound("Proyek tidak ditemukan.");
        }

        $user = session()->get('user');

        $isKetua = $this->projectMemberModel
                        ->where('project_id', $projectId)
                        ->where('user_id', $user['id'])
                        ->where('role', 'ketua')
                        ->countAllResults() > 0;

        return view('project_detail', [
            'members' => $members,
            'project' => $project,
            'isKetua' => $isKetua,
        ]);
    }

    /**
     * Form edit task
     */
public function editTask(int $taskId)
{
    helper('form');  // <-- load helper form

    $task = $this->taskModel->find($taskId);

    if (!$task) {
        throw PageNotFoundException::forPageNotFound("Tugas tidak ditemukan.");
    }

    $project = $this->projectModel->find($task['project_id']);

    return view('project/edit', [
        'task'    => $task,
        'project' => $project,
    ]);
}


    /**
     * Update task
     */
    public function updateTask(int $taskId): ResponseInterface
    {
        $task = $this->taskModel->find($taskId);

        if (!$task) {
            throw PageNotFoundException::forPageNotFound("Tugas tidak ditemukan.");
        }

        $validationRules = [
            'title'  => 'required|min_length[3]',
            'status' => 'required|in_list[todo,doing,done]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->taskModel->update($taskId, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status'),
        ]);

        return redirect()
            ->to(base_url("project/{$task['project_id']}"))
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Delete task
     */
    public function deleteTask(int $taskId): ResponseInterface
    {
        $task = $this->taskModel->find($taskId);

        if (!$task) {
            throw PageNotFoundException::forPageNotFound("Tugas tidak ditemukan.");
        }

        $this->taskModel->delete($taskId);

        return redirect()
            ->to(base_url("project/{$task['project_id']}"))
            ->with('success', 'Tugas berhasil dihapus!');
    }
public function updateStatus(): \CodeIgniter\HTTP\ResponseInterface
{
    $input = $this->request->getJSON();

    $taskId = $input->task_id ?? null;
    $status = $input->status ?? null;

    if (!$taskId || !in_array($status, ['todo', 'doing', 'done'])) {
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid.']);
    }

    $task = $this->taskModel->find($taskId);
    if (!$task) {
        return $this->response->setJSON(['success' => false, 'message' => 'Tugas tidak ditemukan.']);
    }

    $this->taskModel->update($taskId, ['status' => $status]);

    return $this->response->setJSON(['success' => true, 'message' => 'Status tugas diperbarui.']);
}


}
