// <?php

// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;

// class TelegramLoginController extends Controller
// {
//     public function login(Request $request)
//     {
//         $data = $request->validate([
//             'id' => 'required|integer',
//             'first_name' => 'nullable|string',
//             'last_name' => 'nullable|string',
//             'username' => 'nullable|string',
//         ]);

//         $user = User::firstOrCreate(
//             ['telegram_id' => $data['id']],
//             [
//                 'role' => 'user',
//                 'balance' => '0',
//             ]
//         );

//         Auth::login($user, true);

//                 return response()->json([
//             'success' => true,
//             'redirect_url' => url('/index') // Добавляем URL для редиректа
//         ]);
       
//     }
// }