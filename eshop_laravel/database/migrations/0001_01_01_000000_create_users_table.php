<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("DROP TYPE IF EXISTS rola_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS stav_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS sposob_dorucenia_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS sposob_platby_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS stav_platby_enum CASCADE");

        DB::statement("CREATE TYPE rola_enum AS ENUM ('admin', 'zakaznik')");
        DB::statement("CREATE TYPE stav_enum AS ENUM ('nova', 'spracovava_sa', 'odoslana', 'dorucena', 'stornovana')");
        DB::statement("CREATE TYPE sposob_dorucenia_enum AS ENUM ('kurier', 'posta', 'osobny_odber')");
        DB::statement("CREATE TYPE sposob_platby_enum AS ENUM ('karta', 'prevod', 'dobierka')");
        DB::statement("CREATE TYPE stav_platby_enum AS ENUM ('nezaplatena', 'zaplatena')");

        DB::statement("
            CREATE TABLE \"Pouzivatel\" (
                pouzivatel_id SERIAL PRIMARY KEY,
                login VARCHAR(255) NOT NULL UNIQUE,
                heslo TEXT NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                rola rola_enum NOT NULL
            );
        ");

        DB::statement('
            CREATE TABLE IF NOT EXISTS "password_reset_tokens" (
                email VARCHAR(255) PRIMARY KEY,
                token VARCHAR(255) NOT NULL,
                created_at TIMESTAMP
            );
        ');

        DB::statement('
            CREATE TABLE IF NOT EXISTS "sessions" (
                id VARCHAR(255) PRIMARY KEY,
                user_id BIGINT,
                ip_address VARCHAR(45),
                user_agent TEXT,
                payload TEXT NOT NULL,
                last_activity INT NOT NULL
            );
        ');

        DB::statement('CREATE INDEX IF NOT EXISTS sessions_user_id_index ON "sessions"(user_id);');
        DB::statement('CREATE INDEX IF NOT EXISTS sessions_last_activity_index ON "sessions"(last_activity);');
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS "Pouzivatel" CASCADE;');
        DB::statement('DROP TABLE IF EXISTS "password_reset_tokens" CASCADE;');
        DB::statement('DROP TABLE IF EXISTS "sessions" CASCADE;');

        DB::statement("DROP TYPE IF EXISTS rola_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS stav_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS sposob_dorucenia_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS sposob_platby_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS stav_platby_enum CASCADE");
    }
};