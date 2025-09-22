<?php

use App\Models\Color;
use App\Models\Family;
use App\Models\Subcategory;
use App\Models\Supplier;
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
        Schema::create('maxmins', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignIdFor(Supplier::class,'SupplierId');
            $table->foreignIdFor(Subcategory::class,'SubcategoryId');
            $table->foreignIdFor(Color::class,'ColorId');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maxmins');
    }
};
