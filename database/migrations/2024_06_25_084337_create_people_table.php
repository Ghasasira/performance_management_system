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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class, 'user_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(App\Models\Quarter::class)->constrained();
            $table->integer('interperson_relations')->nullable()->default(0);
            $table->integer('respectful')->nullable()->default(0);
            $table->integer('flexible')->nullable()->default(0);
            $table->integer('emotionally_intelligent')->nullable()->default(0);
            $table->integer('positive_attitude')->nullable()->default(0);
            $table->integer('considerate')->nullable()->default(0);
            $table->integer('couteous')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
