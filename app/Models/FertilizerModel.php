<?php

namespace App\Models;

use CodeIgniter\Model;

class FertilizerModel extends Model
{
    protected $table = 'fertilizers';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'nutrients',
        'usage_details',
        'application_method',
        'dosage',
        'suitablecrop',
        'manufacturer',
        'price',
        'image',
        'created_at',
        'fertilizer_type',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
