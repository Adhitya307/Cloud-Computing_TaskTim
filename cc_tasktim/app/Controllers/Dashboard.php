<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\ProjectMemberModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('user')) {
            return redirect()->to('/login');
        }

        $user = session()->get('user');
        $projectMemberModel = new ProjectMemberModel();
        
        $projects = $projectMemberModel
            ->select('projects.*, project_members.role')
            ->join('projects', 'projects.id = project_members.project_id')
            ->where('project_members.user_id', $user['id'])
            ->findAll();

        return view('dashboard', [
            'user' => $user,
            'projects' => $projects
        ]);
    }

    public function create()
    {
        if (!session()->get('user')) {
            return redirect()->to('/login');
        }

        $projectModel = new ProjectModel();
        $projectMemberModel = new ProjectMemberModel();
        $user = session()->get('user');

        $projectId = $projectModel->insert([
            'name' => $this->request->getPost('name'),
            'owner_id' => $user['id']
        ]);

        $projectMemberModel->insert([
            'project_id' => $projectId,
            'user_id' => $user['id'],
            'role' => 'ketua',
            'invited_at' => date('Y-m-d H:i:s'),
            'status' => 'active'
        ]);

        return redirect()->to('/dash')->with('success', 'Project berhasil dibuat!');
    }
}