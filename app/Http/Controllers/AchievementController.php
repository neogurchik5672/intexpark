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
    public function create()
        {
            return view('admin.achievements.create');
        }
    // store() – сохранение новой ачивки
    public function store(Request $request)
    {   
        // Валидация данных
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'intexcoin' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'required_count' => 'required|string'
    ]);

    // Загрузка изображения, если оно есть
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('achievements', 'public');
    }

    // Создаём ачивку
    Achievement::create($data);

    // Перенаправляем обратно
    return redirect()->route('admin.achievements.index')->with('success', 'Ачивка успешно добавлена!');
}
public function destroy(Achievement $achievement)
{
    // Удаляем изображение, если оно было
    if ($achievement->image) {
        Storage::delete($achievement->image);
    }

    // Удаляем ачивку из БД
    $achievement->delete();

    return redirect()->route('admin.achievements.index')->with('success', 'Ачивка успешно удалена');
}

public function edit(Achievement $achievement)
{
    return view('admin.achievements.edit', compact('achievement'));
}

public function update(Request $request, Achievement $achievement)
{
    // Валидация данных
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'intexcoin' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        'required_count' => 'required|string'
    ]);

    // Обработка изображения
    if ($request->hasFile('image')) {
        // Удаляем старое изображение
        if ($achievement->image) {
            Storage::delete($achievement->image);
        }

        // Загружаем новое
        $data['image'] = $request->file('image')->store('achievements', 'public');
    }
    // Обновляем ачивку
    $achievement->update($data);

    // Перенаправляем обратно
    return redirect()->route('admin.achievements.index')->with('success', 'Ачивка успешно добавлена!');
}
}
