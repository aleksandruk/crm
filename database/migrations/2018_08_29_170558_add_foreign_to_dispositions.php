<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToDispositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dispositions', function (Blueprint $table) {
            $table->integer('stock_id')->unsigned()->index()->nullable();
            $table->foreign('stock_id')->references('id')->on('storekeepers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dispositions', function (Blueprint $table) {
            //
        });
    }
}
