<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuoteIdColumnToBulkorders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bulkorders', function (Blueprint $table) {
            $table->unsignedInteger('qoute_id')->nullable()->after('customer_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bulkorders', function (Blueprint $table) {
            $table->dropColumn('qoute_id');
        });
    }
}
