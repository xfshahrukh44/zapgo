<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToGetQuotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('get_quotes', function (Blueprint $table) {
            $table->string('bulk_amount')->nullable()->after('number_of_days');
            $table->string('total_amount')->nullable()->after('bulk_amount');
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
            //
        });
    }
}
