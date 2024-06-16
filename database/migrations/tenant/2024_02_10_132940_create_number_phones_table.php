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
        Schema::create('number_phones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('phone_number')->nullable(); // Champ pour le numéro de téléphone
            $table->enum('type', ['home', 'mobile', 'work', 'other'])->nullable(); // Champ pour le type de number de téléphone
            $table->boolean('is_default')->default(false); // Champ pour savoir si c'est le number par defaults
            $table->string('country_code', 5)->nullable(); // Champ pour le code du pays du number de téléphone
            $table->string('area_code', 5)->nullable(); // Champ pour indication régional du number de téléphone
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('number_phones');
    }
};
