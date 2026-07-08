<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facultes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });

        Schema::create('filieres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculte_id')->nullable();
            $table->string('nom');
            $table->timestamps();
        });

        Schema::create('niveaux', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->timestamps();
        });

        Schema::create('semestres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });

        Schema::create('ues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filiere_id')->nullable();
            $table->unsignedBigInteger('semestre_id')->nullable();
            $table->string('code')->nullable();
            $table->string('libelle')->nullable();
            $table->integer('credits')->nullable();
            $table->timestamps();
        });

        Schema::create('ecues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ue_id')->nullable();
            $table->string('code')->nullable();
            $table->string('libelle')->nullable();
            $table->integer('volume_horaire')->nullable();
            $table->timestamps();
        });

        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('matricule')->nullable();
            $table->string('grade')->nullable();
            $table->string('specialite')->nullable();
            $table->timestamps();
        });

        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enseignant_id')->nullable();
            $table->unsignedBigInteger('ecue_id')->nullable();
            $table->string('annee')->nullable();
            $table->timestamps();
        });

        Schema::create('emplois_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salle_id')->nullable();
            $table->unsignedBigInteger('ecue_id')->nullable();
            $table->unsignedBigInteger('enseignant_id')->nullable();
            $table->date('date')->nullable();
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
            $table->timestamps();
        });

        Schema::create('salles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->integer('capacite')->nullable();
            $table->timestamps();
        });

        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->unsignedBigInteger('ecue_id')->nullable();
            $table->date('date')->nullable();
            $table->string('motif')->nullable();
            $table->timestamps();
        });

        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->unsignedBigInteger('ecue_id')->nullable();
            $table->decimal('devoir', 5, 2)->nullable();
            $table->decimal('examen', 5, 2)->nullable();
            $table->decimal('moyenne', 5, 2)->nullable();
            $table->string('validation')->nullable();
            $table->timestamps();
        });

        Schema::create('deliberations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->decimal('moyenne', 5, 2)->nullable();
            $table->string('decision')->nullable();
            $table->timestamps();
        });

        Schema::create('memoires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->string('theme')->nullable();
            $table->string('directeur')->nullable();
            $table->string('fichier')->nullable();
            $table->timestamps();
        });

        Schema::create('soutenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memoire_id')->nullable();
            $table->unsignedBigInteger('salle_id')->nullable();
            $table->date('date')->nullable();
            $table->time('heure')->nullable();
            $table->timestamps();
        });

        Schema::create('jury', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('soutenance_id')->nullable();
            $table->unsignedBigInteger('enseignant_id')->nullable();
            $table->string('role')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jury');
        Schema::dropIfExists('soutenances');
        Schema::dropIfExists('memoires');
        Schema::dropIfExists('deliberations');
        Schema::dropIfExists('notes');
        Schema::dropIfExists('absences');
        Schema::dropIfExists('salles');
        Schema::dropIfExists('emplois_temps');
        Schema::dropIfExists('affectations');
        Schema::dropIfExists('enseignants');
        Schema::dropIfExists('ecues');
        Schema::dropIfExists('ues');
        Schema::dropIfExists('semestres');
        Schema::dropIfExists('niveaux');
        Schema::dropIfExists('filieres');
        Schema::dropIfExists('facultes');
    }
};
