<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('method', 10);
            $table->text('url');
            $table->text('user_agent')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->text('request_body')->nullable();
            $table->integer('response_code')->nullable();
            $table->timestamp('created_at');
            
            $table->index('ip_address');
            $table->index('created_at');
        });

        Schema::create('sql_logs', function (Blueprint $table) {
            $table->id();
            $table->text('query');
            $table->json('bindings')->nullable();
            $table->float('execution_time');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at');
            
            $table->index('created_at');
        });

        Schema::create('audit_trails', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('action'); // create, update, delete
            $table->unsignedBigInteger('record_id');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at');
            
            $table->index(['table_name', 'record_id']);
            $table->index('created_at');
        });

        Schema::create('security_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type'); // sql_injection_attempt, xss_attempt, brute_force, etc
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->text('description');
            $table->text('evidence')->nullable();
            $table->string('ip_address', 45);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('created_at');
            
            $table->index('event_type');
            $table->index('severity');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_events');
        Schema::dropIfExists('audit_trails');
        Schema::dropIfExists('sql_logs');
        Schema::dropIfExists('request_logs');
    }
};