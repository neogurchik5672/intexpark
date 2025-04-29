<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;

class UserController extends Controller
{
    public function index(){
    $query = User::query()->get();
    return view('user.index', compact('query'));
}
    public function show(){        
        $query = User::query()->first();
        $myEvents = Member::query()->where('user_id',$query->id)->get();
        return view('user.show', compact('query','myEvents'));
    }
}