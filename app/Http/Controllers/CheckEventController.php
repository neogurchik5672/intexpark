<?php

namespace App\Http\Controllers;

use App\Models\CheckEvent;
use App\Models\User;
use App\Models\Events;
use Illuminate\Http\Request;

class CheckEventController extends Controller
{
    public function statusOff($item){
            $balance = User::where('id','1')->first();
            $event = Events::where('id',$item)->first();
            $user = User::where('id','1')->update(['balance' => intval($balance->balance) + intval($event->salary)]);
        $events = CheckEvent::create([
            'user_id' => '1',
            'events_id' => $item,
            'status' => 'true',
        ]); 
        return redirect()->action([UserController::class,'show']);
    }
    public function statusOffNot($item){
    $events = CheckEvent::create([
        'user_id' => '1',
        'events_id' => $item,
        'status' => 'false',
    ]); 
    return redirect()->action([UserController::class,'show']);
}
}
