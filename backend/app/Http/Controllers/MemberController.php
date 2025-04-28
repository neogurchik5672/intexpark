<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Events;

class MemberController extends Controller
{
   public function store(Events $events){
    $query = Events::query()->get();
    $member = Member::create([
        'user_id' => 1,
        'events_id' => $events->id,
    ]); 
    return view('events.index',compact('query'));
   }
}
