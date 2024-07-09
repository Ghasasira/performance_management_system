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
        Schema::create('teamwork', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class, 'user_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(App\Models\Quarter::class)->constrained();
            $table->integer('availability')->nullable()->default(0);
            $table->integer('discipline')->nullable()->default(0);
            $table->integer('participatory')->nullable()->default(0);
            $table->integer('ownership')->nullable()->default(0);
            $table->integer('good_communicator')->nullable()->default(0);
            $table->integer('interactive_listener')->nullable()->default(0);
            $table->integer('provides_feedback')->nullable()->default(0);
            $table->integer('goes_an_extra_mile')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teamwork');
    }
};
