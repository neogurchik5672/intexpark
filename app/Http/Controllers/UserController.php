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
use App\Models\Achievement;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request){
        $query = User::query()->get();
        return view('user.index', compact('query'));
    }
    public function show(){        
        $query = Auth::user();
        $myEvents = Member::query()->where('user_id',$query->id)->get();
        $myBuyRequest = BuyRequest::query()->where('user_id',$query->id)->get();
        $myOrganizatedEvents = Events::query()->where('user_id',$query->id)->get();
        $myHistory = History::query()->where('user_id',$query->id)->get();
        $checkEvents = CheckEvent::query()->where('user_id',$query->id)->where('status','true')->get();
        return view('user.show', compact('query','myEvents','myHistory','myOrganizatedEvents','myBuyRequest'));
    }
    public function updateCoins($id,Request $request){
         $request->validate( [
      'balance'=>'required|integer',
         ]);
        $user = User::where('id',$id)->update([
            'balance' => $request['balance'],
        ]); 
        $admin = Auth::user();
            $user = User::findOrFail($id);
           $CoinTransactionLog = Transaction::create([
            'user_id' => strval( $user->id),
            'admin_id' =>strval(  $admin->id),
            'reason' => null,
        ]); 
        return response()->json([
            'success'=>true,
        ]);
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
    public function addAvatar(Request $request,$id){
        //  $image = Image::updateOrCreate(
        //     ['user_id'=>$id],
        //     [''])
        dd($request);
    }
    public function remove($id){
        $user = User::findOrFail($id);
        $user->delete();        
       return response()->json([
            'success'=>true,
        ]);
    }
    //Профиль пользователя
    public function account()
    {
        $user = Auth::user();
        $myHistory = History::query()->where('user_id', $user->id)->get();
        $achievements = $user->achievements()->get();

        return view('user.account', compact('user', 'myHistory', 'achievements'));
    }

    //Просмотр профиля пользователя (для админа)
    public function user_view($id)
    {
        $currentUser = Auth::user();
        if ($currentUser->role !== 'admin') {
            return redirect('/user/account')->with('error', 'Access denied.');
        }

        $user = User::findOrFail($id);
        $myHistory = History::where('user_id', $user->id)->get();
        $achievements = $user->achievements()->get();

        return view('user.user_view', compact('user', 'myHistory', 'achievements'));
    }

    //Редактирование профиля пользователя (для админа)
    public function user_editing($id)
    {
        $currentUser = Auth::user();
        if ($currentUser->role !== 'admin') {
            return redirect('/user/account')->with('error', 'Access denied.');
        }

        $user = User::findOrFail($id);
        $myHistory = History::where('user_id', $user->id)->get();
        $achievements = $user->achievements()->get();
        $allAchievements = Achievement::all();

        return view('user.user_editing', compact('user', 'myHistory', 'achievements', 'allAchievements'));
    }

    //Добавление/удаление достижений, изменение количества интекскоинов
    public function updateUserData(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'achievement_ids' => 'nullable|array',
            'achievement_ids.*' => 'exists:achievements,id',
            'delete_achievement_ids' => 'nullable|array',
            'delete_achievement_ids.*' => 'exists:achievements,id',
            'balance' => 'nullable|integer|min:0',
        ]);

        $currentUser = Auth::user();
        if ($currentUser->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Access denied.'], 403);
        }

        try {
            $user = User::findOrFail($validated['user_id']);
            $hasChanges = false;

            // Добавление новых достижений
            $newAchievementIds = !empty($validated['achievement_ids'])
                ? array_filter($validated['achievement_ids'], function ($id) use ($user) {
                    return !$user->hasAchievement($id);
                })
                : [];

            if (!empty($newAchievementIds)) {
                $user->achievements()->attach($newAchievementIds);
                $hasChanges = true;
            }

            // Удаление достижений
            $deleteAchievementIds = !empty($validated['delete_achievement_ids'])
                ? array_filter($validated['delete_achievement_ids'], function ($id) use ($user) {
                    return $user->hasAchievement($id);
                })
                : [];

            if (!empty($deleteAchievementIds)) {
                $user->achievements()->detach($deleteAchievementIds);
                $hasChanges = true;
            }

            // Обновление баланса
            if (isset($validated['balance']) && $validated['balance'] !== $user->balance) {
                $user->balance = $validated['balance'];
                $user->save();
                $hasChanges = true;
            }

            if (!$hasChanges) {
                return response()->json(['success' => true, 'message' => 'Нет изменений для сохранения.']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Данные пользователя успешно обновлены.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ошибка при обновлении данных: ' . $e->getMessage()], 500);
        }
    }

    //Удаление пользователя
    public function deleteUser(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $currentUser = Auth::user();
        if ($currentUser->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Access denied.'], 403);
        }

        try {
            $user = User::findOrFail($validated['user_id']);
            // Проверяем, чтобы администратор не удалил самого себя
            if ($user->id === $currentUser->id) {
                return response()->json(['success' => false, 'message' => 'Нельзя удалить самого себя.'], 400);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Пользователь успешно удален.',
                'redirect' => route('user.index'), // Страница со списком всех пользователей(?) нужно поменять маршрут на корректный
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ошибка при удалении пользователя: ' . $e->getMessage()], 500);
        }
    }
    public function ban(User $user)
{
    $user->update(['is_banned' => true]);
    return back()->with('success', 'Пользователь заблокирован');
}

public function unban(User $user)
{
    $user->update(['is_banned' => false]);
    return back()->with('success', 'Пользователь разблокирован');
}
public function showBannedPage()
{
    if (!auth()->check() || !auth()->user()->is_banned) {
        return redirect('/');
    }
    
    return view('banned');
}
}