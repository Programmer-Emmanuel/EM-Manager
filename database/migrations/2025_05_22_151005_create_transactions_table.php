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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('entreprise_id');
            $table->foreign('entreprise_id')
                ->references('id')
                ->on('entreprises')
                ->onDelete('cascade');
            $table->uuid('employe_id')->nullable();
            $table->foreign('employe_id')
                ->references('id')
                ->on('employes')
                ->onDelete('cascade');
            $table->string('motif');
            $table->string('type');
            $table->string('reference')->nullable();
            $table->string('statut')->nullable();
            $table->decimal('montant', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
