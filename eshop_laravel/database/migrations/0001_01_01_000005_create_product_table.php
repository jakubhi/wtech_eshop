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
                cena_bez_zlavy NUMERIC(10, 2),
                kategoria_id INT NOT NULL,
                znacka_id INT NOT NULL,
                skladom INT NOT NULL,
                na_predajni BOOLEAN NOT NULL DEFAULT FALSE,
                na_objednavku BOOLEAN NOT NULL DEFAULT FALSE,
                popis TEXT,
                farba VARCHAR(255),
                material VARCHAR(255),
                sezona VARCHAR(255),
                image_path1 VARCHAR(255),
                image_path2 VARCHAR(255),
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