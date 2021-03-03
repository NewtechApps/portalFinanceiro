<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Parameters extends Model
{
    protected $table = 'parameters';
    protected $primaryKey = 'name';

    public $timestamps    = false;
    public $autoincrement = false;

}


