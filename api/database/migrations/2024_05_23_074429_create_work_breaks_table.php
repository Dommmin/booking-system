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
        Schema::create('work_breaks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'employee_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->date('starts_at_date');
            $table->time('starts_at_time');
            $table->date('ends_at_date');
            $table->time('ends_at_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_breaks');
    }
};
