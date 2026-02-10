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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom_entreprise');
            $table->string('nom_directeur');
            $table->string('prenom_directeur');
            $table->string('telephone_entreprise');
            $table->string('email_entreprise');
            $table->string('motDePasse_entreprise');
            $table->string('matricule_entreprise')->unique();
            $table->string('role')->default('entreprise');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};