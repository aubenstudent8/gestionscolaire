<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('sexe')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();
        });

        Schema::create('pieces_dossiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidat_id')->nullable();
            $table->string('type_piece')->nullable();
            $table->string('fichier')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();

            $table->index('candidat_id');
            $table->foreign('candidat_id')
                  ->references('id')->on('candidats')
                  ->onDelete('set null');
        });

        Schema::create('preinscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidat_id')->nullable();
            $table->unsignedBigInteger('filiere_id')->nullable();
            $table->unsignedBigInteger('niveau_id')->nullable();
            $table->string('annee_universitaire')->nullable();
            $table->string('statut_validation')->nullable();
            $table->timestamps();

            $table->index('candidat_id');
            $table->index('filiere_id');
            $table->index('niveau_id');
            $table->foreign('candidat_id')
                  ->references('id')->on('candidats')
                  ->onDelete('set null');
            $table->foreign('filiere_id')
                  ->references('id')->on('filieres')
                  ->onDelete('set null');
            $table->foreign('niveau_id')
                  ->references('id')->on('niveaux')
                  ->onDelete('set null');
        });

        Schema::create('documents_academiques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->string('type')->nullable();
            $table->string('fichier')->nullable();
            $table->timestamps();

            $table->index('etudiant_id');
            $table->foreign('etudiant_id')
                ->references('id')->on('etudiants')
                ->onDelete('set null');
        });

        Schema::create('sanctions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->string('type')->nullable();
            $table->string('motif')->nullable();
            $table->timestamps();

            $table->index('etudiant_id');
            $table->foreign('etudiant_id')
                ->references('id')->on('etudiants')
                ->onDelete('set null');
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->string('type')->nullable();
            $table->text('raison')->nullable();
            $table->timestamps();

            $table->index('etudiant_id');
            $table->foreign('etudiant_id')
                ->references('id')->on('etudiants')
                ->onDelete('set null');
        });

        Schema::create('abandons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->string('motif')->nullable();
            $table->timestamps();

            $table->index('etudiant_id');
            $table->foreign('etudiant_id')
                ->references('id')->on('etudiants')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abandons');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('sanctions');
        Schema::dropIfExists('documents_academiques');
        Schema::dropIfExists('preinscriptions');
        Schema::dropIfExists('pieces_dossiers');
        Schema::dropIfExists('candidats');
    }
};
