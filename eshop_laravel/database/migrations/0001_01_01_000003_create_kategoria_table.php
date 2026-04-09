<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            CREATE TABLE "Kategoria" (
                id SERIAL PRIMARY KEY,
                nazov VARCHAR(255) NOT NULL,
                kategoria_id INT,
                CONSTRAINT fk_kategoria_parent FOREIGN KEY (kategoria_id) REFERENCES "Kategoria"(id)
            );
        ');
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS "Kategoria" CASCADE;');
    }
};