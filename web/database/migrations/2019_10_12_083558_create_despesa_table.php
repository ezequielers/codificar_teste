<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespesaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despesa', function (Blueprint $table) {
            $table->increments('id_despesa')->unsigned();
            $table->integer('id_deputado')->unsigned()->index('fk_despesa_deputado1_idx');
            $table->double('valor', 8, 2)->nullable()->default(0);
            $table->string('mes', 2);
            $table->year('ano');
            $table->timestamps();

            $table->foreign('id_deputado', 'fk_despesa_deputado1')->references('id_deputado')->on('deputado')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('despesa', function (Blueprint $table) {
            $table->dropForeign('fk_despesas_deputados1');
            $table->dropIfExists('despesa');
        });
    }
}
