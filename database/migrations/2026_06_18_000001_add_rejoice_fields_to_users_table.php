<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rejoice role taxonomy. Kept separate from LinkStack's core `role`
            // column so existing admin access checks remain intact.
            $table->string('rejoice_role')->default('Creator')->after('role');
            $table->string('organization_name')->nullable()->after('rejoice_role');
            $table->string('organization_type')->nullable()->after('organization_name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rejoice_role', 'organization_name', 'organization_type']);
        });
    }
};
