<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('icon', 10)->default('💡');
            $table->string('color', 20)->default('yashil');
            $table->enum('risk_level', ['low', 'medium', 'high', 'all'])->default('all');
            $table->string('category')->nullable(); // muloqot, emotsional, moliyaviy
            $table->json('tags')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};