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
        Schema::create('employe_dossiers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employe_id');
            $table->foreign('employe_id')
                ->references('id')
                ->on('employes')
                ->onDelete('cascade');
            $table->string('nom_fichier'); // nom original
            $table->string('chemin'); // path du fichier
            $table->string('type'); // image ou pdf
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employe_dossiers');
    }
};
