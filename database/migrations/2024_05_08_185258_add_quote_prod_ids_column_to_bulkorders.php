<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuoteProdIdsColumnToBulkorders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bulkorders', function (Blueprint $table) {
            $table->string('quote_prod_ids')->after('customer_phone');
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
            $table->dropColumn('quote_prod_ids');
        });
    }
}
