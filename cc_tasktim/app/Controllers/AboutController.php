<?php namespace App\Controllers;

use CodeIgniter\Controller;

class AboutController extends BaseController
{
    public function index()
    {
        $session = session();
        $user = $session->get('user'); // pastikan sesi ini di-set saat login

        $data = [
            'title' => 'About Us - TaskTim',
            'user' => $user, // <-- Tambahkan ini
            'team' => [
                [
                    'nama' => 'Adhitya Bagus Pratikno',
                    'jabatan' => '2250081159',
                    'email' => 'adhityabagus509@gmail.com',
                    'no_hp' => '081234567890',
                    'bio' => 'terus berenang terus berenang terus berenang ',
                    'foto' => '/assets/1.png'
                ],
                [
                    'nama' => 'ANDIKA WISNU NUGRAHA',
                    'jabatan' => '2250081174',
                    'email' => 'andhikawisnu@gmail.com',
                    'no_hp' => '082345678901',
                    'bio' => '',
                    'foto' => '/assets/2.png'
                ],
                [
                    'nama' => 'FADIL MAULANA DZOHRI ',
                    'jabatan' => '2250081130',
                    'email' => 'fadil@gmail.com',
                    'no_hp' => '083456789012',
                    'bio' => '',
                    'foto' => '/assets/3.png'
                ],
                [
                    'nama' => 'REZA ZALFA AVRIELLA B',
                    'jabatan' => '2250081153',
                    'email' => 'Reza@gmail.com',
                    'no_hp' => '084567890123',
                    'bio' => '',
                    'foto' => '/assets/4.png'
                ],
            ],
        ];

        return view('about_us', $data);
    }
}
