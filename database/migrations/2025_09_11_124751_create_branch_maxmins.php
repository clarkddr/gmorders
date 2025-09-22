<?php

use App\Models\Branch;
use App\Models\Maxmin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('branch_maxmins', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Maxmin::class,'maxmin_id');
            $table->foreignIdFor(Branch::class,'branch_id');
            $table->integer('max')->default(0);
            $table->integer('min')->default(0);
            $table->unique(['maxmin_id', 'branch_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
