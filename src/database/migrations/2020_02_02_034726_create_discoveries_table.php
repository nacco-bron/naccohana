<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscoveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discoveries', function (Blueprint $table) {
            $table->increments('id')->comment('発見ID');
            $table->integer('flower_id')->unsigned()->default(1)->comment('花ID');
            $table->string('address')->collation('utf8_unicode_ci')->nullable()->comment('住所');
            $table->geometry('latlng')->nullable()->comment('緯度経度');
            $table->string('file_name1')->collation('utf8_unicode_ci')->nullable()->comment('ファイル名1');
            $table->string('file_name2')->collation('utf8_unicode_ci')->nullable()->comment('ファイル名2');
            $table->string('file_name3')->collation('utf8_unicode_ci')->nullable()->comment('ファイル名3');
            $table->string('file_name4')->collation('utf8_unicode_ci')->nullable()->comment('ファイル名4');
            $table->dateTime('discovered_at')->nullable()->comment('発見日時');
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
        Schema::dropIfExists('discoveries');
    }
}
