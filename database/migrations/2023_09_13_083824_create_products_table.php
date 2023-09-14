<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit'); // Добавление поля "unit" типа string
            $table->decimal('price', 8, 2); // Добавление поля "price" типа decimal с 8 цифрами и 2 знаками после запятой
            $table->integer('quantity'); // Добавление поля "quantity" типа integer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
