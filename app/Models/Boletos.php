<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Boletos extends Model
{
    protected $table = 'boletos';
    protected $primaryKey = 'id';

    public $timestamps    = false;
    public $autoincrement = true;

}


