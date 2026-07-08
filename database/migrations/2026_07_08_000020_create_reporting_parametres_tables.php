<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->date('date_generation')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();

            $table->index('date_generation');
            $table->index('type');
        });

        Schema::create('parametres_systeme', function (Blueprint $table) {
            $table->id();
            $table->string('cle')->nullable();
            $table->string('valeur')->nullable();
            $table->timestamps();

            $table->index('cle');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parametres_systeme');
        Schema::dropIfExists('rapports');
    }
};
