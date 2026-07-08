<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('sexe')->nullable();
            $table->date('date_naissance')->nullable();
            $table->unsignedBigInteger('nationalite_id')->nullable();
            $table->string('photo')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('carte_etudiant')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();
        });

        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->string('nom');
            $table->string('telephone')->nullable();
            $table->string('profession')->nullable();
            $table->string('lien_parente')->nullable();
            $table->timestamps();
        });

        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('filiere_id')->nullable();
            $table->unsignedBigInteger('niveau_id')->nullable();
            $table->unsignedBigInteger('annee_id')->nullable();
            $table->date('date_inscription')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();
        });

        Schema::create('historiques_academiques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->decimal('moyenne', 5, 2)->nullable();
            $table->string('mention')->nullable();
            $table->string('decision')->nullable();
            $table->timestamps();
        });

        Schema::create('historiques_financiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('paiement_id')->nullable();
            $table->timestamps();
        });

        Schema::create('diplomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->string('diplome')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });

        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->string('entreprise')->nullable();
            $table->string('encadreur')->nullable();
            $table->date('debut')->nullable();
            $table->date('fin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stages');
        Schema::dropIfExists('diplomes');
        Schema::dropIfExists('historiques_financiers');
        Schema::dropIfExists('historiques_academiques');
        Schema::dropIfExists('inscriptions');
        Schema::dropIfExists('parents');
        Schema::dropIfExists('etudiants');
    }
};
