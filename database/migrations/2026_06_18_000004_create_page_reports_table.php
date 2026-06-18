<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_reports', function (Blueprint $table) {
            $table->id();
            // page_id references the reported page owner (users.id).
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('link_id')->nullable();
            $table->string('reason');
            $table->text('description')->nullable();
            $table->string('reporter_email')->nullable();
            $table->string('status')->default('Open');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_reports');
    }
};
