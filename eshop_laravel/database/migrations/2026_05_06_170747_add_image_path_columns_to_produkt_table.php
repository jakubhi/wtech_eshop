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
            $table->string('image_path1')->nullable();
            $table->string('image_path2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Produkt', function (Blueprint $table) {
            $table->dropColumn(['image_path1', 'image_path2']);
        });
    }
};
