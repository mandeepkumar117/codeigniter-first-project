<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function signup()
    {
        return view('pages/signup'); // aapka signup.php
    }
    public function login()
    {
        return view('pages/login');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('fertilizer');
    }

}
