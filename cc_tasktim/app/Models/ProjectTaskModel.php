<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectTaskModel extends Model
{
    protected $table = 'project_tasks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['project_id', 'title', 'description', 'status'];
    protected $validationRules = [
        'title' => 'required|min_length[3]',
        'status' => 'required|in_list[todo,doing,done]',
    ];
}
