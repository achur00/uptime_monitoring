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
    Schema::create('monitors', function (Blueprint $table) {

        $table->id();

        $table->string('url')->unique();

        $table->integer('check_interval')->default(5)->min(1)->max(60);

        $table->integer('threshold')->default(3)->min(1);

        $table->enum('status', ['pending', 'up', 'down'])->default('pending');

        $table->timestamp('last_checked_at')
              ->nullable();

        $table->decimal('uptime_percentage', 5, 2)->nullable();

        $table->integer('consecutive_failures') ->default(0);
        //to avoid duplicate emails notification
        $table->boolean('notification_sent')->default(false);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitors');
    }
};
