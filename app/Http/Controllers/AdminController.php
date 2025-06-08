<?php

namespace App\Http\Controllers;
use finfo;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function products(){
        $query = Product::query()->get();
        return view('admin.products',compact('query'));
    }
        public function transaction(){
        $tra = Transaction::query()->get();
        return view('admin.transaction',compact('tra'));
    }
        public function newAdmin($id){
            $user = User::where('id',$id)->update(['role'=>'admin']);
        return response()->json([
            'success'=>true,
        ]);
        }
}
