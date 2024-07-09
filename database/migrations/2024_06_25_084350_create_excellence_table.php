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
        Schema::create('excellence', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class, 'user_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(App\Models\Quarter::class)->constrained();
            $table->integer('positive_attitude')->nullable()->default(0);
            $table->integer('keeps_time')->nullable()->default(0);
            $table->integer('competent')->nullable()->default(0);
            $table->integer('detailed_planner')->nullable()->default(0);
            $table->integer('good_executor')->nullable()->default(0);
            $table->integer('effective_communicator')->nullable()->default(0);
            $table->integer('follow_through_and_follow_up')->nullable()->default(0);
            $table->integer('efficient')->nullable()->default(0);
            $table->integer('fast_to_deliver')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excellence');
    }
};
