<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\ProjectTaskModel;

class Dash extends BaseController
{
    protected $projectModel;
    protected $taskModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
        $this->taskModel = new ProjectTaskModel();
    }

    public function index()
    {
        if (!session()->get('user')) {
            return redirect()->to('/login');
        }

        $user = session()->get('user');
        $projects = $this->projectModel
            ->where('owner_id', $user['id'])
            ->findAll();

        $formattedProjects = [];
        foreach ($projects as $project) {
            $tasks = $this->taskModel
                ->where('project_id', $project['id'])
                ->findAll();

            $formattedProjects[] = [
                'id'        => $project['id'],
                'name'      => $project['name'],
                'thumbnail' => $project['thumbnail'] ?? 'default-project.png',
                'tasks'     => [
                    'todo'  => array_filter($tasks, fn($task) => $task['status'] === 'todo'),
                    'doing' => array_filter($tasks, fn($task) => $task['status'] === 'doing'),
                    'done'  => array_filter($tasks, fn($task) => $task['status'] === 'done'),
                ],
                'progress'  => $this->calculateProgress($tasks),
                'created_at' => date('d M Y', strtotime($project['created_at']))
            ];
        }

        return view('dash', [
            'projects' => $formattedProjects,
            'user'     => $user
        ]);
    }

    private function calculateProgress(array $tasks): int
    {
        if (empty($tasks)) return 0;
        $doneTasks = count(array_filter($tasks, fn($task) => $task['status'] === 'done'));
        return round(($doneTasks / count($tasks)) * 100);
    }
}