<?php

namespace App\Http\Controllers;

use Chapa\Chapa\Facades\Chapa as Chapa;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Initialize Rave payment process
     * @return void
     */
    protected $reference;

    public function __construct()
    {
        $this->reference = Chapa::generateReference();

    }

    public function initialize()
    {
        //This generates a payment reference
        $reference = $this->reference;

        // Enter the details of the payment
        $data = [
            'amount' => 130,
            'email' => 'abenezer@yifelegal.com',
            'tx_ref' => $reference,
            'currency' => "ETB",
            'callback_url' => route('Payment.callback', [$reference]),
            'first_name' => "Abenezer",
            'last_name' => "Ayalneh",
//            "customization" => [
//                "title" => 'Chapa',
//                "description" => "Testing payment with Chapa"
//            ]
        ];

        $payment = Chapa::initializePayment($data);
        Log::debug($payment);

        if ($payment['status'] !== 'success') {
            // notify something went wrong
            Log::error("Payment failed to proceed");
            return;
        }

        Log::info("Payment Successful");

        return $payment['data']['checkout_url'];
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback($reference)
    {
        $data = Chapa::verifyTransaction($reference);
//        dd($data);
        Log::debug("Chapa verifyTransaction Data");
        Log::debug($data);

        //if payment is successful
        if ($data['status'] == 'success') {
            return ($data);
        } else {
            //oopsie something ain't right.
            Log::error("Verification failed");


        }
    }
}
