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
        Schema::create('conges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_employe');
            $table->uuid('id_entreprise');
            $table->string('type_conge');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('statut')->default('En attente...');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
