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
        Schema::create('employes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_entreprise');
            $table->string('nom_employe');
            $table->string('prenom_employe');
            $table->string('adresse_employe');
            $table->string('telephone');
            $table->string('email_employe');
            $table->string('matricule_employe')->unique();
            $table->string('poste');
            $table->string('departement');
            $table->date('date_embauche');
            $table->string('salaire');
            $table->string('mot_de_passe');
            $table->string('role')->default('employe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
