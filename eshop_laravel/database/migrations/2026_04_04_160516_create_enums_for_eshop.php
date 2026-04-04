<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE TYPE rola_enum AS ENUM ('admin', 'zakaznik')");
        DB::statement("CREATE TYPE stav_enum AS ENUM ('nova', 'spracovava_sa', 'odoslana', 'dorucena', 'stornovana')");
        DB::statement("CREATE TYPE sposob_dorucenia_enum AS ENUM ('kurier', 'posta', 'osobny_odber')");
        DB::statement("CREATE TYPE sposob_platby_enum AS ENUM ('karta', 'prevod', 'dobierka')");
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS rola_enum");
        DB::statement("DROP TYPE IF EXISTS stav_enum");
        DB::statement("DROP TYPE IF EXISTS sposob_dorucenia_enum");
        DB::statement("DROP TYPE IF EXISTS sposob_platby_enum");
    }
};
