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
        Schema::create('url_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('original_url');
            $table->string('short_code', 32)->unique();
            $table->timestamps();

            $table->index('original_url');
            $table->index('short_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url_mappings');
    }
};
