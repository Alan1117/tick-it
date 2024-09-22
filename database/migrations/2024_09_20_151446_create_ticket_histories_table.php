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
        Schema::create('ticket_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Ticket::class);
            $table->foreignIdFor(\App\Models\User::class);
            $table->unsignedBigInteger('previous_ticket_status_id')->nullable();
            $table->unsignedBigInteger('current_ticket_status_id');
            $table->text('reason');
            $table->timestamps();

            $table->foreign('previous_ticket_status_id')->references('id')->on('ticket_statuses');
            $table->foreign('current_ticket_status_id')->references('id')->on('ticket_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_histories');
    }
};
