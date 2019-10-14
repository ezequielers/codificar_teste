<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redes', function (Blueprint $table) {
          $table->integer('id_rede')->unsigned();
            $table->integer('id_deputado')->unsigned()->index('fk_rede_deputado1_idx');
            $table->primary(['id_rede', 'id_deputado']);
            $table->string('nome');
            $table->string('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redes', function (Blueprint $table) {
            $table->dropForeign('fk_rede_deputado1');
        });
    }
}
