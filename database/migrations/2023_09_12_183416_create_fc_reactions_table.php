<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcReactionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fc_reactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->nullable()->references('id')->on('fc_organizations');
            $table->uuid('reactionable_id')->nullable();
            $table->string('reactionable_type')->nullable();
            $table->boolean('is_liked')->default(false);
            $table->boolean('is_not_liked')->default(false);
            $table->string('status')->nullable();
            $table->string('comments')->nullable();
            $table->foreignUuid('creator_user_id')->nullable()->references('id')->on('fc_users');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::update("ALTER TABLE `fc_reactions` ADD INDEX `fc_reactions_type_idx` (`reactionable_id`, `reactionable_type`, `is_liked`, `is_not_liked`);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fc_reactions');
    }
}
