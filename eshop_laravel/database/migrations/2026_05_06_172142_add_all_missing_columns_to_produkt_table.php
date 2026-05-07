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
            if (!Schema::hasColumn('Produkt', 'popis')) {
                $table->text('popis')->nullable();
            }
            if (!Schema::hasColumn('Produkt', 'farba')) {
                $table->string('farba')->nullable();
            }
            if (!Schema::hasColumn('Produkt', 'material')) {
                $table->string('material')->nullable();
            }
            if (!Schema::hasColumn('Produkt', 'image_path1')) {
                $table->string('image_path1')->nullable();
            }
            if (!Schema::hasColumn('Produkt', 'image_path2')) {
                $table->string('image_path2')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Produkt', function (Blueprint $table) {
            $columnsToDrop = [];

            foreach (['popis', 'farba', 'material', 'image_path1', 'image_path2'] as $column) {
                if (Schema::hasColumn('Produkt', $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
