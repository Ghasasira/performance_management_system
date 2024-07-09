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
        Schema::create('subdepartments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(App\Models\User::class, 'supervisor_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(App\Models\Department::class, 'dept_id')->constrained('departments')->onDelete('cascade');
            $table->timestamps();

            // $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            // $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subdepartments');
    }
};
