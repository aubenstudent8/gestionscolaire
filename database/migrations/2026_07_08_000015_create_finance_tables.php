<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('types_frais', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->decimal('montant', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->unsignedBigInteger('type_frais_id')->nullable();
            $table->decimal('montant', 15, 2)->nullable();
            $table->string('mode_paiement')->nullable();
            $table->string('reference')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();

            $table->index('etudiant_id');
            $table->index('type_frais_id');
            $table->foreign('etudiant_id')
                ->references('id')->on('etudiants')
                ->onDelete('set null');
            $table->foreign('type_frais_id')
                  ->references('id')->on('types_frais')
                  ->onDelete('set null');
        });

        Schema::create('bourses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->string('organisme')->nullable();
            $table->decimal('montant', 15, 2)->nullable();
            $table->timestamps();

            $table->index('etudiant_id');
            $table->foreign('etudiant_id')
                ->references('id')->on('etudiants')
                ->onDelete('set null');
        });

        Schema::create('reductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->decimal('pourcentage', 5, 2)->nullable();
            $table->timestamps();

            $table->index('etudiant_id');
            $table->foreign('etudiant_id')
                ->references('id')->on('etudiants')
                ->onDelete('set null');
        });

        Schema::create('journaux_comptables', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('libelle')->nullable();
            $table->decimal('debit', 15, 2)->nullable();
            $table->decimal('credit', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('recettes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->decimal('montant', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->decimal('montant', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('tresorerie', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->decimal('solde', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tresorerie');
        Schema::dropIfExists('depenses');
        Schema::dropIfExists('recettes');
        Schema::dropIfExists('journaux_comptables');
        Schema::dropIfExists('reductions');
        Schema::dropIfExists('bourses');
        Schema::dropIfExists('paiements');
        Schema::dropIfExists('types_frais');
    }
};
