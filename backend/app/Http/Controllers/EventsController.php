<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;

class EventsController extends Controller
{
    public function index() {
        $query = Events::query()->get();
        return view('events.index', compact('query'));
    }
        public function create(){

        
        return view('events.create');
    }
   public function store(Request $request){
    $request->validate( [
        'type'=>'required|string',
        'name'=>'required|string',
        'desc'=>'required|string',
        'count'=>'required|integer',
        'subject'=>'required|string',
        'salary'=>'required|integer',
        'data'=>'string',
        'time'=>'string',
   ]);
    if ($request->type !== 'Offline') {
        $request['data'] = '';
        $request['time'] = '';
    }
    $events = Events::create([
        'user_id' => 1,
        'type' => $request['type'],
        'name' => $request['name'],
        'desc' => $request['desc'],
        'count' => $request['count'],
        'subject' => $request['subject'],
        'salary' => $request['salary'],
        'data' => $request['data'],
        'time' => $request['time'],
    ]); 
    
    return redirect('/');
   }



}

