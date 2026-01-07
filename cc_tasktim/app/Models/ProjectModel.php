<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table      = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'owner_id', 'thumbnail', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
