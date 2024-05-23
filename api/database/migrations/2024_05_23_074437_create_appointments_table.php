<?php

use App\Models\Service;
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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignIdFor(Service::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('employee_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->date('starts_at_date');
            $table->time('starts_at_time');
            $table->foreignId('client_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
