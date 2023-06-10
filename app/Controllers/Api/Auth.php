<?php

namespace App\Controllers\Api;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    // Register a new user
    public function register()
    {
        $rules = $this->validate([
            'username' => 'required|is_unique[users.username]',
            'pin' => 'required|integer|min_length[6]|max_length[6]',
            'age' => 'integer|max_length[3]',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];
            return $this->failValidationErrors($response);
        }

        $username = $this->request->getVar('username');

        $this->userModel->save([
            'username' => $username,
            'pin' => password_hash($this->request->getVar('pin'), PASSWORD_DEFAULT),
            'age' => $this->request->getVar('age'),
            'hobby' => $this->request->getVar('hobby'),
        ]);

        $response = [
            'status' => 'success',
            'message' => 'Account created in successfully',
        ];
        return $this->respondCreated($response);
    }

    // User login
    public function login()
    {
        $rules = $this->validate([
            'username' => 'required',
            'pin' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $username = $this->request->getVar('username');
        $pin = $this->request->getVar('pin');

        // Check if the user exists
        $user = $this->userModel->where('username', $username)->first();

        if (!$user || !password_verify($pin, $user['pin'])) {
            return $this->failUnauthorized('Invalid username or pin');
        }

        return $this->respond([
            'status' => 200,
            'messages' => $user
        ]);
    }
}
