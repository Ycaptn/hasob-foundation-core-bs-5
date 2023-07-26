<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcGatewayPaymentDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fc_gateway_payment_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->references('id')->on('fc_organizations');
            $table->string('payable_type')->nullable();
            $table->uuid('payable_id')->nullable();
            $table->string('type')->nullable();
            $table->string('bank_account_number');
            $table->string('bank_account_name');
            $table->string('bank_name');
            $table->string('bank_sort_code');
            $table->string('gateway_name')->nullable();
            $table->string('account_gateway_code')->nullable();
            $table->string('status')->nullable();
            $table->text('currency')->nullable();
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
        Schema::drop('fc_gateway_payment_details');
    }
}
