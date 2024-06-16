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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->string('name');
            $table->string('slug')->unique()->nullable()->default(null);
            $table->string('email')->unique()->nullable()->default(null);
            $table->string('phone')->unique()->nullable()->default(null);
            $table->string('website')->unique()->nullable()->default(null);
            $table->string('level_min')->nullable()->default(null);
            $table->string('level_max')->nullable()->default(null);
            $table->text('small_description')->nullable()->default(null);
            $table->longText('long_description')->nullable()->default(null);
            $table->enum('status', ['draft', 'published', 'unpublished'])->default('draft');
            $table->string('logo')->nullable()->default(null);
            $table->string('cover')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
