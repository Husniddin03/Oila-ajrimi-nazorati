<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('emoji', 10)->default('📝');
            $table->string('color', 20)->default('#4a7c59');
            $table->enum('category', [
                'muloqot',
                'moliyaviy',
                'emotsional',
                'bola_tarbiyasi',
                'xiyonat',
                'xarakter',
                'moddiy',
                'zovravonlik',
                'ichkilik',
                'uzoq_yashasish',
                'qarindosh',
                'majburiy_nikoh',
            ])->default('muloqot');
            $table->integer('duration_minutes')->default(15);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};