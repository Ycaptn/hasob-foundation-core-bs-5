<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeyIndexToFcModelArtifactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fc_model_artifacts', function (Blueprint $table) {
            //
        });

        //Any artifact stored in the table needs to be keyed on the model_name, id, and key values for speed and optimization.
        DB::update("ALTER TABLE `fc_model_artifacts` ADD INDEX `fc_model_artifacts_model_name_id_key` (`model_name`, `model_primary_id`, `key`);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fc_model_artifacts', function (Blueprint $table) {
            //
        });
    }
}
