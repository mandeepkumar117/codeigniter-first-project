<?php

namespace App\Models;

use CodeIgniter\Model;

class SignupModel extends Model
{
    protected $table = 'userdatatable';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'firstname',
        'lastname',
        'email',
        'password'
    ];
}
