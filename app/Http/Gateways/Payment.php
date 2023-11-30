<?php


namespace App\Http\Gateways;

interface Payment
{
    /**
     * Method to initiate the payment with the provided data
     *
     * @param [type] $data
     * @return void
     */
    public function initiate($data);

    /**
     * method to verify the payment with provided data
     *
     * @param [type] $data
     * @return void
     */
    public function verify($data);

    /**
     * method to handle webhook request from  external APIs
     *
     * @param [type] $data
     * @return void
     */
    public function webhookHandler();
}
