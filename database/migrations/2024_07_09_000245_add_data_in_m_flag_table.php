<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddDataInMFlagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_flag', function (Blueprint $table) {
            //
        });

        DB::table('m_flag')->insert([
            [
                'flag_type' => 'ServiceDate',
                'flag_value' => date('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
                'flag_additionalText' => date('Y-m-d'),
                'has_image' => '0',
                'is_active' => '1',
                'is_config' => '1',
                'flag_show_text' => 'Service Date',
                'is_featured' => 0,
                'is_deleted' => 0,
                'user_id' => 0
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_flag', function (Blueprint $table) {
            //
        });
    }
}
