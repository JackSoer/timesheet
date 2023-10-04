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
        Schema::create('work_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('developer_id');
            $table->unsignedBigInteger('project_id');
            $table->foreign('developer_id')->references('id')->on('developers');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->decimal('rate', 7, 2)->nullable();
            $table->decimal('hrs', 7, 2);
            $table->decimal('total', 12, 2)->nullable();
            $table->integer('status')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_logs');
    }
};
