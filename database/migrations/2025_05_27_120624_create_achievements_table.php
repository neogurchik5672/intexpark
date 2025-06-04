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

    // Таблица achievements (достижения)
    // Содержит информацию об ачивках: название, описание, картинка, сколько интекскоинов даёт, какое условие нужно выполнить.

    public function up()
    {
    Schema::create('achievements', function (Blueprint $table)
        {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->text('intexcoin');
        $table->string('image')->nullable();
        $table->integer('required_count');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('achievements');
    }
};
