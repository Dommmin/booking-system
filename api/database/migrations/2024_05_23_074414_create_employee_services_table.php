<?php

use App\Models\Service;
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
        Schema::create('employee_services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'employee_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignIdFor(Service::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['service_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_services');
    }
};
