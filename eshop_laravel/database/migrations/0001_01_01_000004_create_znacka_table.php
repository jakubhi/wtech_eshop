<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            CREATE TABLE "Znacka" (
                znacka_id SERIAL PRIMARY KEY,
                nazov VARCHAR(255) NOT NULL
            );
        ');
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS "Znacka" CASCADE;');
    }
};