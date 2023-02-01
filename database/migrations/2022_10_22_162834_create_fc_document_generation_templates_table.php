<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcDocumentGenerationTemplatesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fc_document_generation_templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->references('id')->on('fc_organizations');
            $table->integer('display_ordinal')->default(0);
            $table->string('title');
            $table->string('document_layout')->nullable();
            $table->text('content', 2000)->nullable();
            $table->string('output_content_types')->nullable();
            $table->string('file_name_prefix')->nullable();
            $table->foreignUuid('creator_user_id')->nullable()->references('id')->on('fc_users');
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
        Schema::drop('fc_document_generation_templates');
    }
}
