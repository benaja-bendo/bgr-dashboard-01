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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('street', 255)->nullable(); // Champ pour la rue
            $table->string('number', 10)->nullable(); // Champ pour le numéro
            $table->string('complement', 255)->nullable(); // Champ pour le complément d'adresse
            $table->string('city', 255)->nullable(); // Champ pour la ville
            $table->string('zip_code', 10)->nullable(); // Champ pour le code postal
            $table->string('country', 255)->nullable(); // Champ pour le pays
            $table->boolean('is_default')->default(false); // Champ pour savoir si c'est le number par defaults
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
