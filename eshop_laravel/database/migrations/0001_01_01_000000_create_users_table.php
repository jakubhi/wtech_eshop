<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("DROP TYPE IF EXISTS rola_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS stav_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS sposob_dorucenia_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS sposob_platby_enum CASCADE");

        DB::statement("CREATE TYPE rola_enum AS ENUM ('admin', 'zakaznik')");
        DB::statement("CREATE TYPE stav_enum AS ENUM ('nova', 'spracovava_sa', 'odoslana', 'dorucena', 'stornovana')");
        DB::statement("CREATE TYPE sposob_dorucenia_enum AS ENUM ('kurier', 'posta', 'osobny_odber')");
        DB::statement("CREATE TYPE sposob_platby_enum AS ENUM ('karta', 'prevod', 'dobierka')");

        DB::statement("
            CREATE TABLE \"Pouzivatel\" (
                pouzivatel_id SERIAL PRIMARY KEY,
                login VARCHAR(255) NOT NULL UNIQUE,
                heslo TEXT NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                rola rola_enum NOT NULL
            );
        ");

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS "Pouzivatel" CASCADE;');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');

        DB::statement("DROP TYPE IF EXISTS rola_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS stav_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS sposob_dorucenia_enum CASCADE");
        DB::statement("DROP TYPE IF EXISTS sposob_platby_enum CASCADE");
    }
};