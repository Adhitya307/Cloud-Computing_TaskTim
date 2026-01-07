<?php namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table = 'team'; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'jabatan',
        'email',
        'no_hp',
        'bio',
        'foto',
        'linkedin',
        'twitter'
    ];
    protected $useTimestamps = true;

    public function getAllMembers()
    {
        return $this->orderBy('id', 'ASC')->findAll();
    }

    public function getMemberById($id)
    {
        return $this->find($id);
    }
}
