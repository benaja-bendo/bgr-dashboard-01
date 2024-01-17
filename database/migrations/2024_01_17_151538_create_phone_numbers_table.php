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
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->string('number', 20); // Champ pour le numéro de téléphone
            $table->enum('type', ['fixe', 'mobile', 'fax', 'autre'])->nullable(); // Champ pour le type de numéro de téléphone
            $table->string('country_code', 5)->nullable(); // Champ pour le code du pays du numéro de téléphone
            $table->string('area_code', 5)->nullable(); // Champ pour l'indicatif régional du numéro de téléphone
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_numbers');
    }
};
