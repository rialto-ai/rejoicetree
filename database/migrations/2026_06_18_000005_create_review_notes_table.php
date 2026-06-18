<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_notes', function (Blueprint $table) {
            $table->id();
            // page_id references the reviewed page owner (users.id).
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('link_id')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->text('note');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_notes');
    }
};
