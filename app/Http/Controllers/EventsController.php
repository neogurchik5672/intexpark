<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Member;
use App\Models\User;

class EventsController extends Controller
{
    public function index() {
        $query = Events::query()->get();
        $user = User::query()->first();
        return view('events.index', compact('query','user'));
    }
    public function create(){
        return view('events.create');
    }
   public function store(Request $request){
    $query = Events::query()->get();
    $data = '';
    $time = '';
    $request->validate( [
        'type'=>'required|string',
        'name'=>'required|string',
        'desc'=>'required|string',
        'count'=>'required|integer',
        'subject'=>'required|string',
        'salary'=>'required|integer',
   ]);
    if ($request->type !== 'Offline') {
        $data = '';
        $time = '';
    }else{
        $data = $request['data'];
        $time = $request['time'];
    }
    $events = Events::create([
        'user_id' => 1,
        'type' => $request['type'],
        'name' => $request['name'],
        'desc' => $request['desc'],
        'count' => $request['count'],
        'subject' => $request['subject'],
        'salary' => $request['salary'],
        'data' => $data,
        'time' => $time,
    ]); 
    return redirect()->action([EventsController::class, 'index']);
   }
}

