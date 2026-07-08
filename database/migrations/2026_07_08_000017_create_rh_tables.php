<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('poste')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });

        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personnel_id')->nullable();
            $table->string('type')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamps();

            $table->index('personnel_id');
            $table->foreign('personnel_id')
                  ->references('id')->on('personnels')
                  ->onDelete('set null');
        });

        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personnel_id')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('type')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();

            $table->index('personnel_id');
            $table->foreign('personnel_id')
                  ->references('id')->on('personnels')
                  ->onDelete('set null');
        });

        Schema::create('salaires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personnel_id')->nullable();
            $table->decimal('montant', 15, 2)->nullable();
            $table->string('periode')->nullable();
            $table->timestamps();

            $table->index('personnel_id');
            $table->foreign('personnel_id')
                  ->references('id')->on('personnels')
                  ->onDelete('set null');
        });

        Schema::create('evaluations_personnel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personnel_id')->nullable();
            $table->unsignedBigInteger('evaluateur_id')->nullable();
            $table->text('commentaires')->nullable();
            $table->integer('note')->nullable();
            $table->timestamps();

            $table->index('personnel_id');
            $table->index('evaluateur_id');
            $table->foreign('personnel_id')
                  ->references('id')->on('personnels')
                  ->onDelete('set null');
            $table->foreign('evaluateur_id')
                  ->references('id')->on('personnels')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations_personnel');
        Schema::dropIfExists('salaires');
        Schema::dropIfExists('conges');
        Schema::dropIfExists('contrats');
        Schema::dropIfExists('personnels');
    }
};
