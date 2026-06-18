<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->string('block_type')->nullable()->after('type');
            // Block-specific structured fields (e.g. music/podcast URLs) as JSON.
            $table->text('block_params')->nullable()->after('block_type');
            $table->string('review_status')->default('Unreviewed')->after('block_params');
            $table->string('support_type')->nullable()->after('review_status');
            $table->boolean('tax_deductible_claimed')->default(false)->after('support_type');
            $table->string('support_entity_name')->nullable()->after('tax_deductible_claimed');
            $table->boolean('review_required')->default(false)->after('support_entity_name');
        });
    }

    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn([
                'block_type', 'block_params', 'review_status',
                'support_type', 'tax_deductible_claimed',
                'support_entity_name', 'review_required',
            ]);
        });
    }
};
