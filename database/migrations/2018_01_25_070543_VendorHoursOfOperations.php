<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VendorHoursOfOperations extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('vendor_hours_of_operations')) {
            Schema::create('vendor_hours_of_operations', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('vendor_id');
                $table->integer('days');
                $table->dateTime('open_time');
                $table->dateTime('close_time');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('vendor_hours_of_operations');
    }

}
