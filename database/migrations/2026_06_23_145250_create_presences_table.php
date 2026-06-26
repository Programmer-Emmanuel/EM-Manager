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
        Schema::create('presences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_employe');
            $table->uuid('id_entreprise');
            
            $table->foreign('id_employe')
                ->references('id')
                ->on('employes')
                ->onDelete('cascade');
            
            $table->foreign('id_entreprise')
                ->references('id')
                ->on('entreprises')
                ->onDelete('cascade');
            
            $table->date('date');
            $table->time('heure_arrivee');
            $table->time('heure_depart')->nullable();

            $table->string('adresse_pointage')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->string('adresse_ip')->nullable();
            $table->string('navigateur')->nullable();
            
            $table->enum('statut', ['present', 'retard', 'absent', 'congé', 'mission'])->default('present');
            $table->timestamps();
            
            $table->unique(['id_employe', 'date']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
