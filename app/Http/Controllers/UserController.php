<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\BuyRequest;
use App\Models\Events;
use App\Models\CheckEvent;
use App\Models\History;
use App\Models\Transaction;


class UserController extends Controller
{
    public function index(Request $request){
    $query = User::query()->get();
    return view('user.index', compact('query'));
}
    public function show(){        
        $query = User::query()->first();
        $myEvents = Member::query()->where('user_id',$query->id)->get();
        $myBuyRequest = BuyRequest::query()->where('user_id',$query->id)->get();
        $myOrganizatedEvents = Events::query()->where('user_id',$query->id)->get();
        $myHistory = History::query()->where('user_id',$query->id)->get();
        // $checkEvents = CheckEvent::query()->where('user_id',$query->id)->where('status','true')->get();
        return view('user.show', compact('query','myEvents','myHistory','myOrganizatedEvents','myBuyRequest'));
    }
    public function updateCoins($id,Request $request){
       
         $request->validate( [
      'balance'=>'required|integer',
         ]);
    $user = User::findOrFail($id);

          $user = User::where('id',$id)->update([
            'balance' => $request['balance'],
        ]); 

          $CoinTransactionLog = Transaction::create([
            'user_id' => 1,
            'admin_id' => 1,
            'reason' => $request['reason'],
        ]); 
        return redirect()->back();

    }
        public function updateCoin($id,Request $request){
         $request->validate( [
      'coins'=>'required|integer',
      'reason'=>'required|string',
         ]);
        $user = User::query()->where('id',$id)->first();
        $user->balance = intval($user->balance) - $request['coins'];
        $user->save();
           $CoinTransactionLog = Transaction::create([
            'user_id' => 1,
            'admin_id' => 1,
            'reason' => $request['reason'],
        ]); 
        return redirect()->back();
    }
        public function all($id){        
        $query = User::findOrFail($id);
        $myEvents = Member::query()->where('user_id',$query->id)->get();
        $myBuyRequest = BuyRequest::query()->where('user_id',$query->id)->get();
        $myOrganizatedEvents = Events::query()->where('user_id',$query->id)->get();
        $myHistory = History::query()->where('user_id',$query->id)->get();
        // $checkEvents = CheckEvent::query()->where('user_id',$query->id)->where('status','true')->get();
        return view('user.all', compact('query','myEvents','myHistory','myOrganizatedEvents','myBuyRequest'));
    }
}