<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BusinessRating extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('vendor_rating')) {
            Schema::create('vendor_rating', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id');
                $table->bigInteger('vendor_id');
                $table->integer('rating');
                $table->string('comments');
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
        Schema::drop('vendor_rating');
    }

}
