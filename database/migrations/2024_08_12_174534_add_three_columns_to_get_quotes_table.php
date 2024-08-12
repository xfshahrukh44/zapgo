<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThreeColumnsToGetQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('get_quotes', function (Blueprint $table) {
            $table->string('zip')->nullable()->after('state');
            $table->string('delivery_time')->nullable()->after('zip');
            $table->string('pickup_time')->nullable()->after('delivery_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('get_quotes', function (Blueprint $table) {
            $table->dropColumn('zip');
            $table->dropColumn('delivery_time');
            $table->dropColumn('pickup_time');
        });
    }
}
