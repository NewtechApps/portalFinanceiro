<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;    

use App\Models\EventLog;
class eventLogServices
{


    public static function create($user, $log)
    {
        $event = new EventLog();
        $event->user_id  = $user;
        $event->data_log = Carbon::now();
        $event->mensagem = $log;
        $event->save();
    }

    
}