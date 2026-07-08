<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->date('date_consultation')->nullable();
            $table->text('diagnostic')->nullable();
            $table->timestamps();

            $table->index('etudiant_id');
            $table->foreign('etudiant_id')
                ->references('id')->on('etudiants')
                ->onDelete('set null');
        });

        Schema::create('soins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('consultation_id');
            $table->foreign('consultation_id')
                ->references('id')->on('consultations')
                ->onDelete('set null');
        });

        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->string('vaccin')->nullable();
            $table->date('date_vaccination')->nullable();
            $table->timestamps();

            $table->index('etudiant_id');
            $table->foreign('etudiant_id')
                ->references('id')->on('etudiants')
                ->onDelete('set null');
        });

        Schema::create('allergies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->string('substance')->nullable();
            $table->string('reaction')->nullable();
            $table->timestamps();

            $table->index('etudiant_id');
            $table->foreign('etudiant_id')
                ->references('id')->on('etudiants')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('allergies');
        Schema::dropIfExists('vaccinations');
        Schema::dropIfExists('soins');
        Schema::dropIfExists('consultations');
    }
};
