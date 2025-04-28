<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
    $query = User::query()->get();
    return view('user.index', compact('query'));
}
    public function show(){
        $query = User::query()->first();
        return view('user.show', compact('query'));
    }
}