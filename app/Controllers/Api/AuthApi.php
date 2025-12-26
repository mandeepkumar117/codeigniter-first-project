<?php

namespace App\Controllers\Api;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Controllers\BaseController;
use App\Models\SignupModel;

class AuthApi extends BaseController
{
    public function signup()
    {
        helper('form');

        $rules = [
            'firstname'        => 'required|min_length[3]|max_length[20]',
            'lastname'         => 'required|min_length[3]|max_length[20]',
            'email'            => 'required|min_length[8]|max_length[50]|valid_email|is_unique[userDataTable.email]',
            'password'         => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status'  => false,
                    'message' => $this->validator->getErrors()
                ]);
        }

        $model = new SignupModel();

        $newData = [
            'firstname' => $this->request->getPost('firstname'),
            'lastname'  => $this->request->getPost('lastname'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
        ];

        if ($model->insert($newData)) {
            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Registration successful'
            ]);
        }

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'status'  => false,
                'message' => 'Something went wrong'
        ]);
    }

    //this is session based
    
    // public function login()
    // {
    //     $rules = [
    //         'email'    => 'required|valid_email',
    //         'password' => 'required|min_length[8]',
    //     ];

    //     if (! $this->validate($rules)) {
    //         return $this->response->setStatusCode(422)->setJSON([
    //             'status'  => false,
    //             'message' => $this->validator->getErrors(),
    //         ]);
    //     }

    //     $model = new SignupModel();
    //     $user  = $model->where('email', $this->request->getPost('email'))->first();

    //     if (! $user || ! password_verify($this->request->getPost('password'), $user['password'])) {
    //         return $this->response->setJSON([
    //             'status'  => false,
    //             'message' => 'Invalid email or password',
    //         ]);
    //     }

    //     session()->set([
    //         'isLoggedIn' => true,
    //         'userId'     => $user['id'],
    //         'userName'   => $user['firstname'],
    //     ]);

    //     return $this->response->setJSON([
    //         'status'  => true,
    //         'message' => 'Login successful',
    //     ]);
    // }

public function login()
{
    $rules = [
        'email'    => 'required|valid_email',
        'password' => 'required|min_length[8]',
    ];

    if (! $this->validate($rules)) {
        return $this->response->setStatusCode(422)->setJSON([
            'status'  => false,
            'message' => $this->validator->getErrors(),
        ]);
    }

    $model = new SignupModel();
    $user  = $model->where('email', $this->request->getPost('email'))->first();

    if (! $user || ! password_verify($this->request->getPost('password'), $user['password'])) {
        return $this->response->setStatusCode(401)->setJSON([
            'status'  => false,
            'message' => 'Invalid email or password',
        ]);
    }

    // 🔐 JWT PAYLOAD
    $payload = [
        'iat'  => time(),
        'exp'  => time() + 3600, // 1 hour
        'uid'  => $user['id'],
        'name' => $user['firstname'],
        'email'=> $user['email']
    ];

    // 🔑 JWT TOKEN
    $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

    return $this->response->setJSON([
        'status' => true,
        'token'  => $token,
    ]);
}

}
