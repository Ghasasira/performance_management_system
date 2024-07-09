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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class, 'user_id')->constrained('users')->onDelete('cascade')->unique();
            $table->foreignIdFor(App\Models\Department::class, 'department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignIdFor(App\Models\Subdepartment::class, 'subdepartment_id')->constrained('subdepartments')->onDelete('cascade')->nullable();
            $table->string('role');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
