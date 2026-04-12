<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('
            CREATE TABLE "Polozka_kosika" (
                id SERIAL PRIMARY KEY,
                pouzivatel_id INT NOT NULL,
                produkt_id INT NOT NULL,
                mnozstvo INT NOT NULL DEFAULT 1,
                CONSTRAINT fk_kosik_pouzivatel FOREIGN KEY (pouzivatel_id) REFERENCES "Pouzivatel"(pouzivatel_id) ON DELETE CASCADE,
                CONSTRAINT fk_kosik_produkt FOREIGN KEY (produkt_id) REFERENCES "Produkt"(produkt_id) ON DELETE CASCADE
            );
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS "Polozka_kosika" CASCADE;');
    }
};
