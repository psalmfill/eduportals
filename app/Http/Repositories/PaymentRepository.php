<?php

namespace App\Http\Repositories;

// use Illuminate\Support\Str;

use App\Http\Gateways\FlutterWavePayment;
use App\Models\Payment;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Carbon\Carbon;



class PaymentRepository
{
    public $paymentGateway;
    protected $cardRepository;
    public static $response;
    protected $model;


    public function __construct()
    {
        $this->paymentGateway = app(FlutterWavePayment::class);
        $this->model = app(Payment::class);
    }

    public function createWithModel($payment)
    {
        $payload = [
            'tx_ref' => $payment->reference,
            'amount' => $payment->amount,
            'currency' => 'NGN', #$payment->amount_currency,
            'redirect_url' => route('payment.callback'),
            'meta' => [
                'payment_id' => $payment->id,
                'user_id' => $payment->user_id,
            ],
            'customer' => [
                'email' => $payment->school->email,
                'phone_number' => $payment->school->phone_number,
                'full_name' => $payment->school->name,
            ],
        ];

        $response = $this->paymentGateway->initiate($payload);
        return $response;
    }

    public function update($data, $id)
    {
        $payment = $this->model->findOrFail($id);
        if ($payment->update($data)) {

            return $payment->fresh();
        }
        return false;
    }

    public function verifyPayment($id)
    {
        $payment = $this->model->findOrFail($id);
        if ($payment->status == 'completed') {
            return $payment;
        }
        $response = $this->paymentGateway->verify([
            'tx_ref' => $payment->reference,
        ]);
        if ($response['status'] == 'successful') {
            $payment->update([
                'status' => 'completed',
            ]);
        } else {
            $payment->update([
                'status' => 'failed',
            ]);
        }
        return $payment->fresh();
    }


    public function getPaymentByReference($reference)
    {
        $payment = $this->model->where('reference', $reference)->first();
        return $payment;
    }

    public function handleCallback($data)
    {
        $payment = $this->getPaymentByReference($data['tx_ref']);
        if ($payment) {
            // if (!isset($data['transaction_id'])) {

            //     $payment->update([
            //         'status' => 'failed',
            //         'meta_data' => $data,
            //     ]);
            //     $payment->paymentable->update([
            //         'status' => 'failed',
            //     ]);
            // } else {
            $paymentData =  $this->paymentGateway->verify($data);
            $completed = $paymentData->data->status == 'successful';
            $payment->update([
                'status' => $completed ? 'completed' : 'failed',
                'meta_data' => json_encode($paymentData),
            ]);
            $payment->paymentable->update([
                'status' =>  $completed ? 'completed' : 'failed',
            ]);
            // }
            return $payment->fresh();
        } else {
            abort(404);
        }
    }
}
