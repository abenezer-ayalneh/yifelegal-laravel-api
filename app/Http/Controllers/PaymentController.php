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

    public function initialize(): \Illuminate\Http\JsonResponse
    {
        //This generates a payment reference
        $reference = $this->reference;

        // Enter the details of the payment
        $data = [
            'amount' => 130,
            'email' => 'abenezer@yifelegal.com',
            'tx_ref' => $reference,
            'currency' => "ETB",
            'callback_url' => 'https://example.com',
//            'callback_url' => route('Payment.callback', [$reference]),
            'first_name' => "Abenezer",
            'last_name' => "Ayalneh",
            "customization" => [
                "title" => 'YIFELEGAL',
                "description" => "Testing payment with Chapa"
            ]
        ];

        $payment = Chapa::initializePayment($data);

        if ($payment['status'] !== 'success') {
            // notify something went wrong
            Log::error("Payment failed to proceed");
            Log::error($payment);
            return response()->json([
                "status" => false,
                "message" => "Error processing payment",
                "data" => [],
                "error" => 'Payment failed to proceed',
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Payment processed successfully",
            "data" => ["checkoutUrl" => $payment['data']['checkout_url'],],
            "error" => [],
        ]);
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
