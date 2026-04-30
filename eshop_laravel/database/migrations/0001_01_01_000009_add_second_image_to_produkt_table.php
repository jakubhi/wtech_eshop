<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('Produkt', function (Blueprint $table) {
            $table->string('obrazok_hlavny')->default('images/product1.png')->after('na_objednavku');
            $table->string('obrazok_druhy')->default('images/product2.png')->after('obrazok_hlavny');
        });
    }

    public function down(): void
    {
        Schema::table('Produkt', function (Blueprint $table) {
            $table->dropColumn(['obrazok_hlavny', 'obrazok_druhy']);
        });
    }
};
