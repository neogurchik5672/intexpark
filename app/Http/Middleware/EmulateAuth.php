// <?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\User;

// class EmulateAuth
// {
//     public function handle(Request $request, Closure $next)
//     {
//         // Проверяем, не авторизован ли уже пользователь
//         if (!Auth::check()) {
//             // Эмулируем авторизацию пользователя с ID=1 и role='admin'
//             $user = User::find(1); // Или выберите другой ID для тестирования
//             if (!$user) {
//                 // Если пользователь не найден, создаем тестового
//                 $user = User::create([
//                     'name' => 'Test Admin',
//                     'email' => 'admin@example.com',
//                     'password' => bcrypt('password'),
//                     'tg_id' => 'admin123',
//                     'role' => 'admin',
//                     'balance' => 100,
//                 ]);
//             }
//             Auth::login($user);
//         }

//         return $next($request);
//     }
// }
