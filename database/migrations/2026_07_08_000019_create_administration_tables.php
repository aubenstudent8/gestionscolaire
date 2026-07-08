<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departements', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->timestamps();
            $table->index('nom');
        });

        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('adresse')->nullable();
            $table->timestamps();
            $table->index('nom');
            $table->index('adresse');
        });

        Schema::create('logistiques', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->index('type');
        });

        Schema::create('politiques', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->text('contenu')->nullable();
            $table->timestamps();
            $table->index('titre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('politiques');
        Schema::dropIfExists('logistiques');
        Schema::dropIfExists('sites');
        Schema::dropIfExists('departements');
    }
};
