<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcPaymentDisbursementsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fc_payment_disbursements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->references('id')->on('fc_organizations');
            $table->decimal('amount', 12, 2);
            $table->foreignUuid('gateway_payment_detail_id')->references('id')->on('fc_gateway_payment_details');
            $table->string('gateway_url')->nullable();
            $table->string('gateway_reference_code')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->text('gateway_initialization_response')->nullable();
            $table->text('payment_instrument_type')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_verification_passed')->default(0);
            $table->boolean('is_verification_failed')->default(0);
            $table->datetime('transaction_date')->nullable();
            $table->decimal('verified_amount', 12, 2)->nullable();
            $table->text('verification_meta')->nullable();
            $table->text('verification_notes')->nullable();
            $table->string('wf_status')->nullable();
            $table->text('wf_meta_data')->nullable();
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
        Schema::drop('fc_payment_disbursements');
    }
}
