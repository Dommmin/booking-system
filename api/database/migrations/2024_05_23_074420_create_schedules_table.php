<?php

use App\Models\User;
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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'employee_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->time('monday_starts_at')->nullable();
            $table->time('monday_ends_at')->nullable();
            $table->time('tuesday_starts_at')->nullable();
            $table->time('tuesday_ends_at')->nullable();
            $table->time('wednesday_starts_at')->nullable();
            $table->time('wednesday_ends_at')->nullable();
            $table->time('thursday_starts_at')->nullable();
            $table->time('thursday_ends_at')->nullable();
            $table->time('friday_starts_at')->nullable();
            $table->time('friday_ends_at')->nullable();
            $table->time('saturday_starts_at')->nullable();
            $table->time('saturday_ends_at')->nullable();
            $table->time('sunday_starts_at')->nullable();
            $table->time('sunday_ends_at')->nullable();
            $table->timestamps();

            $table->unique(['employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
