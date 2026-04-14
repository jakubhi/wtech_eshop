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
        Schema::table('Produkt', function (Blueprint $table) {
            $table->boolean('na_predajni')->default(false);
            $table->boolean('na_objednavku')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Produkt', function (Blueprint $table) {
            $table->dropColumn(['na_predajni', 'na_objednavku']);
        });
    }
};
