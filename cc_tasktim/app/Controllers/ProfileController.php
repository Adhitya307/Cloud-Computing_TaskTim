<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
public function index()
{
$user = session()->get('user');
if (!$user) {
    return redirect()->to('/login')->with('error', 'Silakan login dulu');
}
$userId = $user['id'];

    $userModel = new UserModel();
    $user = $userModel->find($userId);

    if (!$user) {
        return redirect()->to('/login')->with('error', 'User tidak ditemukan');
    }

    // Debug log (hapus setelah yakin)
    // log_message('debug', 'User ID di session: ' . $userId);

    return view('profile/index', ['user' => $user]);
}


    public function update()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input
        $validationRules = [
            'nama' => 'required|min_length[3]',
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($validationRules)) {
            // Ambil pesan error dari validator
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }

        $userModel = new UserModel();
        $data = $this->request->getPost(['nama', 'email']);

        $userModel->update($userId, $data);

        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
