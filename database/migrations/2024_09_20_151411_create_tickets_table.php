<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user_id');
            $table->foreignIdFor(\App\Models\TicketStatus::class)->nullable();
            $table->foreignIdFor(\App\Models\TicketType::class)->nullable();
            $table->string('title');
            $table->text('description');
            $table->tinyInteger('is_resolved')->default(false);
            $table->dateTime('resolved_at')->nullable();
            $table->unsignedBigInteger('resolved_by_user_id')->nullable();
            $table->timestamps();

            $table->foreign('resolved_by_user_id')->references('id')->on('users');
            $table->foreign('created_by_user_id')->references('id')->on('users');
        });

        Schema::create('ticket_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('description');
            $table->text('priority');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
