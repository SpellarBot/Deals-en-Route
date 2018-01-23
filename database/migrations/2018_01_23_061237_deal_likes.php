<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DealLikes extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('deal_likes')) {
            Schema::create('deal_likes', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('like_by');
                $table->bigInteger('coupon_id');
                $table->tinyInteger('is_like');
                $table->timestamps();
            });
        }
    }

    /**
     * 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('deal_likes');
    }

}
