<?php

namespace App\Observers;


use App\Facades\SMS;
use App\Models\Verification;

class VerificationObserver
{
    /**
     * Handle the Verification "created" event.
     *
     * @param  \App\Models\Verification  $verification
     * @return void
     */
    public function created(Verification $verification)
    {
        $apiKey = "NmxgXph4NawzHQrmpTaMRbWZigexb2xp3MkimwrTUNE=";
        $client = new \IPPanel\Client($apiKey);
        $bulkID = $client->sendPattern(
            "uw6nxcuhaj",    // pattern code
            "3000505",      // originator
            "$verification->mobile",  // recipient
            ['OTP' =>  "$verification->code"] // pattern values
        );

        //SMS::send($verification->mobile , $verification->code);
    }
}
