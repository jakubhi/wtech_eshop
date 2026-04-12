<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            CREATE TABLE "Dodacie_udaje" (
                dodacie_udaje_id SERIAL PRIMARY KEY,
                meno VARCHAR(255) NOT NULL,
                priezvisko VARCHAR(255) NOT NULL,
                telefon VARCHAR(30) NOT NULL,
                email VARCHAR(255) NOT NULL,
                mesto VARCHAR(255) NOT NULL,
                ulica VARCHAR(255) NOT NULL,
                psc VARCHAR(10) NOT NULL,
                stat VARCHAR(255) NOT NULL,
                sposob_dorucenia sposob_dorucenia_enum NOT NULL
            );
        ');

        DB::statement('
            CREATE TABLE "Objednavka" (
                objednavka_id SERIAL PRIMARY KEY,
                pouzivatel_id INT NOT NULL,
                dodacie_udaje_id INT,
                stav stav_enum NOT NULL,
                CONSTRAINT fk_objednavka_pouzivatel FOREIGN KEY (pouzivatel_id) REFERENCES "Pouzivatel"(pouzivatel_id),
                CONSTRAINT fk_objednavka_dodacie FOREIGN KEY (dodacie_udaje_id) REFERENCES "Dodacie_udaje"(dodacie_udaje_id)
            );
        ');

        DB::statement('
            CREATE TABLE "Polozka_objednavky" (
                objednavka_id INT NOT NULL,
                produkt_id INT NOT NULL,
                PRIMARY KEY (objednavka_id, produkt_id),
                CONSTRAINT fk_polozka_objednavka FOREIGN KEY (objednavka_id) REFERENCES "Objednavka"(objednavka_id),
                CONSTRAINT fk_polozka_produkt FOREIGN KEY (produkt_id) REFERENCES "Produkt"(produkt_id)
            );
        ');

        DB::statement('
            CREATE TABLE "Platba" (
                platba_id SERIAL PRIMARY KEY,
                objednavka_id INT NOT NULL,
                suma NUMERIC NOT NULL,
                sposob_platby sposob_platby_enum NOT NULL,
                CONSTRAINT fk_platba_objednavka FOREIGN KEY (objednavka_id) REFERENCES "Objednavka"(objednavka_id)
            );
        ');
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS "Platba" CASCADE;');
        DB::statement('DROP TABLE IF EXISTS "Polozka_objednavky" CASCADE;');
        DB::statement('DROP TABLE IF EXISTS "Objednavka" CASCADE;');
        DB::statement('DROP TABLE IF EXISTS "Dodacie_udaje" CASCADE;');
    }
};
