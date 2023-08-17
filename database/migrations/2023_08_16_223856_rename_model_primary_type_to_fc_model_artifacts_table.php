<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameModelPrimaryTypeToFcModelArtifactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       // DB::update("ALTER TABLE `fc_model_artifacts` DROP INDEX `fc_model_artifacts_model_name_id_key`;");
        
        Schema::table('fc_model_artifacts', function (Blueprint $table) {
            //
            $table->renameColumn('model_primary_id', 'artifactable_id');
            $table->renameColumn('model_name', 'artifactable_type');
        });

        DB::update("ALTER TABLE `fc_model_artifacts` ADD INDEX `fc_model_artifacts_artifactable_type_id_key` (`artifactable_type`, `artifactable_id`, `key`);");
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
