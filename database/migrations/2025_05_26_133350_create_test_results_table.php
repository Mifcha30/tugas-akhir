<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // database/migrations/xxxx_xx_xx_create_test_results_table.php
public function up()
{
    Schema::create('test_results', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('phone');
        $table->string('test_type'); // e.g. 'komunikasi'
        $table->json('answers');     // user answers
        $table->integer('score');    // total score
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};

