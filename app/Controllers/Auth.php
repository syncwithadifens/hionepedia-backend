<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $session = session();
        if ($session->has('role') && $session->get('role') == 'admin') {
            return redirect()->to('/animal');
        }

        $data = [
            'title' => 'Form login',
            'validation' => \Config\Services::validation()
        ];
        return view('auth/login', $data);
    }

    public function login()
    {
        $data = [
            'title' => 'Form login',
            'validation' => \Config\Services::validation()
        ];
        return view('auth/login', $data);
    }

    public function doLogin()
    {

        if (!$this->validate([
            'username' => 'required',
            'pin' => 'required'
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }
        $username = $this->request->getVar('username');
        $pin = $this->request->getVar('pin');
        $user = $this->userModel->where('username', $username)->first();

        if ($user) {
            if (password_verify($pin, $user['pin'])) {
                if ($user['role'] == 'admin') {
                    // Store user data in session
                    $sessionData = [
                        'user_id' => $user['user_id'],
                        'username' => $user['username'],
                        'role' => $user['role']
                    ];
                    session()->set($sessionData);
                    session()->setFlashdata('pesan', 'Login berhasil');
                    return redirect()->to('/animal');
                } else {
                    return redirect()->back()->withInput()->with('pesan', 'Akun ini tidak terdaftar sebagai admin');
                }
            }
        }

        return redirect()->back()->withInput()->with('pesan', 'Username / Pin Salah');
    }

    public function register()
    {
        $data = [
            'title' => 'Form registrasi',
            'validation' => \Config\Services::validation()
        ];
        return view('auth/register', $data);
    }

    public function doRegister()
    {

        if (!$this->validate([
            'username' => 'required|is_unique[users.username]',
            'pin' => 'required|integer|min_length[6]|max_length[6]',
            'age' => 'integer|max_length[3]',
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $this->userModel->save([
            'username' => $this->request->getVar('username'),
            'pin' => password_hash($this->request->getVar('pin'), PASSWORD_DEFAULT),
            'age' => $this->request->getVar('age'),
            'hobby' => $this->request->getVar('hobby'),
        ]);

        session()->setFlashdata('pesan', 'Registrasi berhasil');
        return redirect()->to('/login');
    }

    public function getAllUser()
    {
        $data = [
            'status' => 'User',
            'title' => 'Semua User',
            'user' => $this->userModel->findAll()
        ];
        return view('auth/index', $data);
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('pesan', 'User berhasil dihapus');
        return redirect()->to('/user');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
