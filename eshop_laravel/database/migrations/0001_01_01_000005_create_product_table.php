<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            CREATE TABLE "Produkt" (
                produkt_id SERIAL PRIMARY KEY,
                nazov VARCHAR(255) NOT NULL,
                pouzivatel_id INT NOT NULL,
                cena NUMERIC NOT NULL,
                kategoria_id INT NOT NULL,
                znacka_id INT NOT NULL,
                skladom INT NOT NULL,
                CONSTRAINT fk_produkt_pouzivatel FOREIGN KEY (pouzivatel_id) REFERENCES "Pouzivatel"(pouzivatel_id),
                CONSTRAINT fk_produkt_kategoria FOREIGN KEY (kategoria_id) REFERENCES "Kategoria"(id),
                CONSTRAINT fk_produkt_znacka FOREIGN KEY (znacka_id) REFERENCES "Znacka"(znacka_id)
            );
        ');
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS "Produkt" CASCADE;');
    }
};