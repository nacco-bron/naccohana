<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddress1Address2Address3ToDiscoveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discoveries', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->integer('pref_id')->after('flower_id')->unsigned()->nullable()->comment('都道府県ID');
            $table->string('address1')->after('pref_id')->collation('utf8_unicode_ci')->nullable()->comment('住所1');
            $table->string('address2')->after('address1')->collation('utf8_unicode_ci')->nullable()->comment('住所2');
            $table->string('address3')->after('address2')->collation('utf8_unicode_ci')->nullable()->comment('住所3');
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
