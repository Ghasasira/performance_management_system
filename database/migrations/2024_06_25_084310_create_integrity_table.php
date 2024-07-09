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
        Schema::create('integrity', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class, 'user_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(App\Models\Quarter::class)->constrained();
            $table->integer('honest')->nullable()->default(0);
            $table->integer('trustworthy')->nullable()->default(0);
            $table->integer('reliable')->nullable()->default(0);
            $table->integer('truthtelling')->nullable()->default(0);
            $table->integer('loyal')->nullable()->default(0);
            $table->integer('accountable')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrity');
    }
};
