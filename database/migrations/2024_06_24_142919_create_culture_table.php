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
    Schema::create('culture', function (Blueprint $table) {
        $table->id();
        $table->foreignIdFor(App\Models\User::class, 'user_id')->constrained('users')->onDelete('cascade');
        $table->foreignIdFor(App\Models\Quarter::class)->constrained();
        $table->integer('integrity')->nullable()->default(0);
        $table->integer('equity')->nullable()->default(0);  // Consider using a smaller range for rating
        $table->integer('people')->nullable()->default(0);    // Consider using a smaller range for rating
        $table->integer('excellence')->nullable()->default(0);
        $table->integer('teamwork')->nullable()->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('culture');
    }
};
