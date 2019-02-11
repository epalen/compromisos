<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // CREA TABLA DE USUARIOS
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('charge');
            $table->string('phone');
            $table->boolean('is_admin');            
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('user_type', ['government', 'society']);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // CREA TABLA DE COMPROMISOS
        Schema::create('commitments', function($table){
          $table->increments('id');
          $table->integer('commitment_num');
          $table->string('title');
          $table->string('plan')->nullable();
          $table->text('description');
          $table->text('characteristics');
          $table->text('status');
          $table->timestamps();
        });

        // CREA USUARIOS - TABLA DE COMPROMISOS
        Schema::create('commitment_user', function($table){
          $table->increments('id');
          $table->unsignedInteger('user_id');
          $table->unsignedInteger('commitment_id');

          $table->foreign('commitment_id')
            ->references('id')
            ->on('commitments')
            ->onDelete('cascade');

          $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        });

        // CREA LA TABLA DE PASOS
        Schema::create('steps', function($table){
          $table->increments('id');
          $table->unsignedInteger('commitment_id');
          $table->date('ends');
          $table->enum('step_num', ['1','2','3','4']);
          $table->timestamps();

          $table->foreign('commitment_id')
            ->references('id')
            ->on('commitments')
            ->onDelete('cascade');
        });

        // CREA LA TABLA DE OBJETIVOS
        Schema::create('objectives', function($table){
          $table->increments('id');
          $table->unsignedInteger('step_id');
          $table->integer('step_num');
          $table->integer('event_num');
          $table->enum('status', ['a', 'b', 'c', 'd']);
          $table->text('description')->nullable();
          $table->text('description_excerpt')->nullable();
          $table->string('mir_url')->nullable();
          $table->string('mir_file')->nullable();
          $table->string('url')->nullable();
          $table->text('advance_description')->nullable();
          $table->text('finish_description')->nullable();
          $table->string('selfie')->nullable(); // the new field
          $table->text('comments')->nullable();
          $table->timestamps();
          $table->text('title')->nullable();

          $table->foreign('step_id')
            ->references('id')
            ->on('steps')
            ->onDelete('cascade');
        });

        // CREA LA TABLA DE AGENTES
        Schema::create('agents', function($table){
          $table->increments('id');
          $table->unsignedInteger('objective_id');
          $table->string('agent')->nullable();
          $table->string('agent_url')->nullable();
          $table->timestamps();

          $table->foreign('objective_id')
            ->references('id')
            ->on('objectives')
            ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
        Schema::dropIfExists('objectives');
        Schema::dropIfExists('steps');
        Schema::dropIfExists('commitment_user');
        Schema::dropIfExists('commitments');
        Schema::dropIfExists('users');
    }
}
