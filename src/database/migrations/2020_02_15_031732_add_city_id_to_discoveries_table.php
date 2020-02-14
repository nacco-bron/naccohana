<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityIdToDiscoveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discoveries', function (Blueprint $table) {
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('address3');
            $table->integer('city_id')->after('pref_id')->unsigned()->nullable()->comment('市区町村ID');
            $table->string('address')->after('city_id')->collation('utf8_unicode_ci')->nullable()->comment('住所');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discoveries', function (Blueprint $table) {
            //
        });
    }
}
