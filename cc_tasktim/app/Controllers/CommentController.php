<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\ProjectTaskModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class CommentController extends BaseController
{
    protected $commentModel;
    protected $taskModel;
    protected $userModel;

    public function __construct()
    {
        $this->commentModel = new CommentModel();
        $this->taskModel    = new ProjectTaskModel();
        $this->userModel    = new UserModel();
    }

    /**
     * Simpan komentar baru
     */
    public function store(): ResponseInterface
    {
        $user = session()->get('user');
        $taskId = (int) $this->request->getPost('task_id');

        if (!$user || !$taskId || !$this->request->getPost('comment')) {
            return redirect()->back()->with('error', 'Komentar tidak boleh kosong.');
        }

        $this->commentModel->insert([
            'task_id' => $taskId,
            'user_id' => $user['id'],
            'comment' => $this->request->getPost('comment'),
        ]);

        return redirect()->back()->with('success', 'Komentar ditambahkan.');
    }
}
