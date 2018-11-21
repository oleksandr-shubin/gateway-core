<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('given_name');
            $table->string('family_name');
            $table->string('email');
            $table->integer('company_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['email', 'deleted_at']);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropUnique(['email', 'deleted_at']);
        });

        Schema::dropIfExists('customers');
    }
}
