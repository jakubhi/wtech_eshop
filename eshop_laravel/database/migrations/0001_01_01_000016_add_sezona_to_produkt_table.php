<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('Produkt', function (Blueprint $table) {
            if (!Schema::hasColumn('Produkt', 'sezona')) {
                $table->string('sezona')->nullable()->after('material');
            }
        });
    }

    public function down(): void
    {
        Schema::table('Produkt', function (Blueprint $table) {
            if (Schema::hasColumn('Produkt', 'sezona')) {
                $table->dropColumn('sezona');
            }
        });
    }
};
