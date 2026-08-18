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
        Schema::create('projects', function (Blueprint $table) {
            $table->id('project_id');
            $table->string('project_name');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('due_date');
            $table->enum('status', ['Planning', 'In Progress', 'Completed'])->default('Planning');
            $table->foreignId('created_by')
                            ->constrained('users', 'user_id')
                            ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
