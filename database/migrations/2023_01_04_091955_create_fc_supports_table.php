<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fc_supports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id')->nullable();
            $table->foreign('organization_id')->references('id')->on('fc_organizations');
            $table->string('location')->nullable();
            $table->string('support_type')->nullable();
            $table->string('issue_type')->nullable();
            $table->uuid('designation_department_id')->nullable();
            $table->foreign('designation_department_id')->references('id')->on('fc_departments');
            $table->string('severity')->nullable();        
            $table->text('description')->nullable();
            $table->uuid('creator_user_id');
            $table->foreign('creator_user_id')->references('id')->on('fc_users');
            $table->uuid('designated_user_id')->nullable();
            $table->foreign('designated_user_id')->references('id')->on('fc_users');
            $table->boolean('status')->default(false);
            $table->dateTime('resolved_at')->nullable();
            $table->uuid('completed_by_user_id')->nullable();
            $table->foreign('completed_by_user_id')->references('id')->on('fc_users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fc_supports');
    }
}
