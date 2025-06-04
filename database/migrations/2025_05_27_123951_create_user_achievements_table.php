<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // Таблица user_achievements
    // Хранит связь между пользователями и разблокированными ачивками.
    public function up()
    {
        Schema::create('user_achievements', function (Blueprint $table)
        {
        $table->id();
    // используем constrained('users') и constrained('achievements'), чтобы указать точные названия таблиц. 
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('achievement_id')->constrained('achievements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_achievements');
    }
};
