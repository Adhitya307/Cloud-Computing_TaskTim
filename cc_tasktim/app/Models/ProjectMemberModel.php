<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectMemberModel extends Model
{
    protected $table      = 'project_members'; // Nama tabel di database
    protected $primaryKey = 'id';               // Kolom primary key
    protected $allowedFields = ['project_id', 'user_id', 'role', 'invited_at', 'status']; // Kolom-kolom yang boleh diinsert
    public $timestamps = false;                 // Jika tidak menggunakan timestamp otomatis (created_at, updated_at)

    /**
     * Mendapatkan anggota proyek berdasarkan project_id
     * 
     * @param int $projectId
     * @return array
     */
    public function getMembersByProject($projectId)
    {
        return $this->where('project_id', $projectId)->findAll(); // Mengambil data anggota berdasarkan project_id
    }
}
