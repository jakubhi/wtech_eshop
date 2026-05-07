<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('Produkt', function (Blueprint $table) {
            if (!Schema::hasColumn('Produkt', 'cena_bez_zlavy')) {
                $table->decimal('cena_bez_zlavy', 10, 2)->nullable()->after('cena');
            }
        });
    }

    public function down(): void
    {
        Schema::table('Produkt', function (Blueprint $table) {
            if (Schema::hasColumn('Produkt', 'cena_bez_zlavy')) {
                $table->dropColumn('cena_bez_zlavy');
            }
        });
    }
};
