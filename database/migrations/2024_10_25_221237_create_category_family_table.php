<?php

use App\Models\Category;
use App\Models\Family;
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
        Schema::create('category_family', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class,'CategoryId');
            $table->foreignIdFor(Family::class,'FamilyId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_family');
    }
};
