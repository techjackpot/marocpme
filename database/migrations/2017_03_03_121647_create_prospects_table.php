<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nom');
            $table->string('Prenom');
            $table->string('fonction')->nullable();
            $table->string('tel')->nullable();
            $table->string('mail')->unique();
            $table->enum('sex', array('M', 'F'))->nullable();


            $table->string('RS');
            $table->date('dateCreation')->nullable();
            $table->string('activite')->nullable();
            $table->string('secteur')->nullable();
            $table->string('ville')->nullable();
            $table->string('fax')->nullable();
            $table->enum('chiffreAff', array('zT', 'tTH'))->nullable();

            $table->boolean('imtiaz');
            $table->boolean('moussanada');
            $table->boolean('tahfiz');
            $table->boolean('istitmar');
            $table->boolean('systemeInfo');
            $table->boolean('startUp');
            $table->boolean('consultance');
            $table->enum('autoEntr', array('porteurP', 'UPI'))->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospects');
    }
}
