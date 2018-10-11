<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeterminablesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('determinables', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('filetype')->nullable();
            $table->string('mimetype');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('determinables');
    }

}
