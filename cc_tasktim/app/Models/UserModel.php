<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'users';
    protected $allowedFields = ['nama', 'email', 'password', 'reset_token', 'reset_token_expired_at'];
    protected $useTimestamps = true;

    // Fungsi untuk mengambil data pengguna berdasarkan ID
    public function getUserById($id)
    {
        return $this->find($id); // Mengambil pengguna berdasarkan ID
    }
}
