<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableFlowersAddComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flowers', function (Blueprint $table) {
            $table->increments('id')->comment('花ID')->change();
            $table->string('name')->collation('utf8_unicode_ci')->comment('花名')->change();
            $table->integer('family_id')->unsigned()->default(1)->comment('科ID')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flowers', function (Blueprint $table) {
            //
        });
    }
}
