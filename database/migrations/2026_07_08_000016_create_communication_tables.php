<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediteur_id')->nullable();
            $table->unsignedBigInteger('destinataire_id')->nullable();
            $table->string('objet')->nullable();
            $table->text('contenu')->nullable();
            $table->timestamps();

            $table->index('expediteur_id');
            $table->index('destinataire_id');
            $table->foreign('expediteur_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
            $table->foreign('destinataire_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });

        Schema::create('sms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utilisateur_id')->nullable();
            $table->string('destinataire')->nullable();
            $table->text('contenu')->nullable();
            $table->timestamp('date_envoi')->nullable();
            $table->timestamps();

            $table->index('utilisateur_id');
            $table->foreign('utilisateur_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });

        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utilisateur_id')->nullable();
            $table->string('destinataire')->nullable();
            $table->string('sujet')->nullable();
            $table->text('contenu')->nullable();
            $table->timestamp('date_envoi')->nullable();
            $table->timestamps();

            $table->index('utilisateur_id');
            $table->foreign('utilisateur_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utilisateur_id')->nullable();
            $table->string('type')->nullable();
            $table->text('contenu')->nullable();
            $table->boolean('vue')->default(false);
            $table->timestamps();

            $table->index('utilisateur_id');
            $table->foreign('utilisateur_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('emails');
        Schema::dropIfExists('sms');
        Schema::dropIfExists('messages');
    }
};
