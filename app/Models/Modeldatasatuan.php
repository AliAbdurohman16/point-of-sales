<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeldatasatuan extends Model
{
    protected $table      = 'satuan';
    protected $primaryKey = 'satid';

    protected $allowedFields = ['satid', 'satnama'];
}