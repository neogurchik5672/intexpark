<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\BuyRequest;
use App\Models\Events;


class UserController extends Controller
{
    public function index(){
    $query = User::query()->get();
    return view('user.index', compact('query'));
}
    public function show(){        
        $query = User::query()->first();
        $myEvents = Member::query()->where('user_id',$query->id)->get();
        $myBuyRequest = BuyRequest::query()->where('user_id',$query->id)->get();
        $myOrganizatedEvents = Events::query()->where('user_id',$query->id)->get();
        return view('user.show', compact('query','myEvents','myOrganizatedEvents','myBuyRequest'));

    }
}