<?php

use App\Models\Branch;
use App\Models\Category;
use App\Models\Family;
use App\Models\Projection;
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
        Schema::create('projection_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Projection::class);
            $table->foreignIdFor(Branch::class,'BranchId');
            $table->foreignIdFor(Family::class,'FamilyId');
            $table->float('new_sale');
            $table->float('old_sale');
            $table->float('purchase');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projection_amounts');
    }
};
