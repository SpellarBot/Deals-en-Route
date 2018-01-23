<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DealComments extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('deal_comments')) {
            Schema::create('deal_comments', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('comment_by');
                $table->bigInteger('coupon_id');
                $table->string('comment_desc');
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
        Schema::drop('deal_comments');
    }

}
