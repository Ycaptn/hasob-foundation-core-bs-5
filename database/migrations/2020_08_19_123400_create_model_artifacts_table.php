<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelArtifactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('fc_model_artifacts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('model_name');
            $table->uuid('model_primary_id');

            $table->string('key');
            $table->text('value')->nullable();
            $table->binary('binary_value')->nullable();

            $table->uuid('invocation_id')->nullable();
            $table->string('invocation_controller_class')->nullable();
            $table->string('invocation_controller_method')->nullable();
            $table->string('invocation_route_name')->nullable();

            $table->uuid('organization_id')->nullable();
            $table->foreign('organization_id')->references('id')->on('fc_organizations');

            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();

        //AAny artifact stored in the table needs to be keyed on the model_name, id, and key values for speed and optimization.
        DB::update("ALTER TABLE `fc_model_artifacts` ADD INDEX `fc_model_artifacts_model_name_id_key` (`model_name`, `model_primary_id`, `key`);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('fc_model_artifacts');
        Schema::enableForeignKeyConstraints();
    }
}
