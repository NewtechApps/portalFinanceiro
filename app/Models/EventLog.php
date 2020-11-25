<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EventLog extends Model
{
    protected $table = 'event_log';
    protected $primaryKey = 'id';

    public $timestamps    = false;
    public $autoincrement = true;

}
