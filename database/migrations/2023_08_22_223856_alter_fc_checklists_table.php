<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFcChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('fc_checklist_templates', function (Blueprint $table) {
            
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_informational')->default(false);
            $table->boolean('is_true_false')->default(false);
            $table->boolean('requires_video_capture')->default(false);
            $table->boolean('requires_picture_capture')->default(false);
            $table->boolean('requires_file_attachment')->default(false);
            $table->string('required_file_attachment_types')->nullable();
            $table->integer('required_attachment_max_size_mb')->default(100);
            $table->boolean('requires_payment')->default(false);
            $table->decimal('required_payment_amount', 15, 2)->default(0);
            $table->boolean('requires_multiple_selection')->default(false);
            $table->boolean('requires_single_selection')->default(false);
            $table->boolean('requires_number_input')->default(false);
            $table->text('selection_values')->nullable();
            $table->string('depends_on_checklist_item_name')->nullable();
            $table->string('depends_on_checklist_item_value')->nullable();

        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fc_checklist_templates', function (Blueprint $table) {
        });
    }
}
