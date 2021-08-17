<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fc_settings', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('key');
            $table->text('value')->nullable();
            $table->binary('binary_value')->nullable();

            $table->string('group_name')->nullable();
            $table->string('model_type')->nullable();
            $table->string('model_value')->nullable();

            $table->uuid('organization_id')->nullable();
            $table->foreign('organization_id')->references('id')->on('fc_organizations');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fc_settings');
    }
}
