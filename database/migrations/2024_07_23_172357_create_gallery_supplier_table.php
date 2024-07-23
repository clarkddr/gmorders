<?php

use App\Models\Gallery;
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
        Schema::create('gallery_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Gallery::class)->cascadeOnDelete();
            $table->foreignIdFor(Supplier::class)->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_supplier');
    }
};
