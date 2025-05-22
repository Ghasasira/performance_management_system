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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table-> string('title');
            $table->integer("weight");
            $table->mediumText('description');
            $table-> date('deadline');
            $table->boolean("is_locked")->nullable()->default(false);
            $table->boolean("is_admin_locked")->nullable()->default(false);
            $table->boolean("is_approved")->nullable()->default(false);
            $table->string("status")->nullable()->default('pending');
            $table->integer('score')->nullable()->default(0);
            $table->foreignIdFor(App\Models\User::class)->constrained();
            $table->foreignIdFor(App\Models\Quarter::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
