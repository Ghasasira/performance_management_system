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
        Schema::create('equity', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class, 'user_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(App\Models\Quarter::class)->constrained();
            $table->integer('fair')->nullable()->default(0);
            $table->integer('equal_opportunity')->nullable()->default(0);
            $table->integer('non_tribalistic')->nullable()->default(0);
            $table->integer('non_nepotistic')->nullable()->default(0);
            $table->integer('gender_blind')->nullable()->default(0);
            $table->integer('ethnic_blind')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equity');
    }
};
