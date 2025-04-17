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
        Schema::create('projection_months', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Family::class, 'FamilyId');
            $table->foreignIdFor(\App\Models\Projection::class);
            $table->integer('month');
            $table->float('percentage');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projection_months');
    }
};
