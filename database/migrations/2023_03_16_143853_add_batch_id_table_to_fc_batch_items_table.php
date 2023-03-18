<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBatchIdTableToFcBatchItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fc_batch_items', function (Blueprint $table) {
            //
            $table->uuid('batch_id')->nullable();
            $table->foreign('batch_id')->references('id')->on('fc_batches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fc_batch_items', function (Blueprint $table) {
            //
        });
    }
}
