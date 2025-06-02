<?php

namespace App\Http\Controllers;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class AchievementController extends Controller
{

    public function index(Request $request)
    {
    $achievements = Achievement::all();
    // $user = auth()->user(); или любой другой способ получить пользователя
    // return view('achievements.index', compact('achievements', 'user'));
    return view('admin.achievements.index', compact('achievements'));
    }
   

}
