<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Task::class, 'task_id')->constrained('tasks')->onDelete('cascade');
            $table->foreignIdFor(App\Models\User::class, 'user_id')->constrained('users')->onDelete('cascade');
            $table->string("ip_address");
            $table->string('type'); // e.g., 'submit', 'update', 'delete', 'add_attachment'
            $table->text('description')->nullable(); // Optional detailed description
            $table->json('metadata')->nullable(); // Store additional context or details
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actions');
    }
}
