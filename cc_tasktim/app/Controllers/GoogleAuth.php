<?php namespace App\Controllers;

use App\Models\UserModel;

class GoogleAuth extends BaseController
{
    public function redirect()
    {
        $client = new \Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope('email');
        $client->addScope('profile');

        return redirect()->to($client->createAuthUrl());
    }

    public function callback()
    {
        $client = new \Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        if ($this->request->getVar('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));

            if (isset($token['error'])) {
                // Jika ada error, bisa logging atau redirect dengan pesan error
                log_message('error', 'Google OAuth token error: ' . $token['error']);
                return redirect()->to('/login')->with('error', 'Gagal login dengan Google: ' . $token['error']);
            }

            $client->setAccessToken($token['access_token']);
            $google_oauth = new \Google_Service_Oauth2($client);
            $google_user = $google_oauth->userinfo->get();

            $userModel = new UserModel();
            $existingUser = $userModel->where('email', $google_user->email)->first();

            if (!$existingUser) {
                $userModel->save([
                    'nama' => $google_user->name,
                    'email' => $google_user->email,
                    'password' => null // Belum punya password
                ]);
                $existingUser = $userModel->where('email', $google_user->email)->first();
            }

            // Set session dengan key 'user' untuk filter auth
            session()->set('user', $existingUser);

            // Jika belum punya password, arahkan ke atur sandi
            if (empty($existingUser['password'])) {
                return redirect()->to('/atur-password');
            }

            return redirect()->to('/dash');
        }

        return redirect()->to('/login')->with('error', 'Kode otorisasi tidak ditemukan');
    }
}
