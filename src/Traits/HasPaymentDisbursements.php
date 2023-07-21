<?php
namespace Hasob\FoundationCore\Traits;

use Hasob\FoundationCore\Models\PaymentDisbursement;

trait HasPayments
{

    public function get_successful_payment()
    {
        return PaymentDisbursement::where('status', 'success')
            ->where('payable_id', $this->id)
            ->where('payable_type', self::class)
            ->where('is_verified', true)
            ->first();
    }

    public function has_successful_payment()
    {
        return (PaymentDisbursement::where('status', 'success')
                ->where('payable_id', $this->id)
                ->where('payable_type', self::class)
                ->where('is_verified', true)->count() >= 1);
    }

    public function has_failed_payments()
    {
        return (PaymentDisbursement::where('status', 'failed')
                ->where('payable_id', $this->id)
                ->where('payable_type', self::class)
                ->where('is_verified', true)->count() >= 1);
    }

    public function total_verified_payment_amount()
    {
        return (PaymentDisbursement::where('payable_id', $this->id)
                ->where('payable_type', self::class)
                ->where('is_verified', true)->sum('verified_amount'));
    }

    public function get_failed_payments()
    {
        return PaymentDisbursement::where('status', 'failed')
            ->where('payable_id', $this->id)
            ->where('payable_type', self::class)
            ->where('is_verified', true)->get();
    }

    public function get_current_payment_attempt()
    {
        return PaymentDisbursement::where('status', 'pending')
            ->where('payable_id', $this->id)
            ->where('payable_type', self::class)
            ->orderBy('created_at', 'DESC')->first();
    }

    public function create_payment_disbursement($amount = 0.0, $reference_code = null)
    {

        $pay_attempt = new PaymentDisbursement();
        $pay_attempt->organization_id = $this->organization_id;
        $pay_attempt->status = 'pending';
        $pay_attempt->amount = $amount;
        $pay_attempt->attempt_code = $reference_code;
        $pay_attempt->payable_id = $this->id;
        $pay_attempt->payable_type = self::class;
        $pay_attempt->save();

        return $pay_attempt;
    }

    public function get_all_payment_attempts($gateway_name = null)
    {
        return PaymentDisbursement::where('payable_id', $this->id)->where('payable_type', self::class)->get();
    }

}
