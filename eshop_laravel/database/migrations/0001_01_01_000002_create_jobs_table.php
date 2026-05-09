<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            CREATE TABLE IF NOT EXISTS "jobs" (
                id BIGSERIAL PRIMARY KEY,
                queue VARCHAR(255) NOT NULL,
                payload TEXT NOT NULL,
                attempts SMALLINT NOT NULL CHECK (attempts >= 0),
                reserved_at INT,
                available_at INT NOT NULL,
                created_at INT NOT NULL
            );
        ');

        DB::statement('CREATE INDEX IF NOT EXISTS jobs_queue_index ON "jobs"(queue);');

        DB::statement('
            CREATE TABLE IF NOT EXISTS "job_batches" (
                id VARCHAR(255) PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                total_jobs INT NOT NULL,
                pending_jobs INT NOT NULL,
                failed_jobs INT NOT NULL,
                failed_job_ids TEXT NOT NULL,
                options TEXT,
                cancelled_at INT,
                created_at INT NOT NULL,
                finished_at INT
            );
        ');

        DB::statement('
            CREATE TABLE IF NOT EXISTS "failed_jobs" (
                id BIGSERIAL PRIMARY KEY,
                uuid VARCHAR(255) NOT NULL UNIQUE,
                connection TEXT NOT NULL,
                queue TEXT NOT NULL,
                payload TEXT NOT NULL,
                exception TEXT NOT NULL,
                failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            );
        ');
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS "jobs" CASCADE;');
        DB::statement('DROP TABLE IF EXISTS "job_batches" CASCADE;');
        DB::statement('DROP TABLE IF EXISTS "failed_jobs" CASCADE;');
    }
};
