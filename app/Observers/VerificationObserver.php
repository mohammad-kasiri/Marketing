<?php

namespace App\Observers;



use App\Models\Verification;
use App\Sms\SMS;

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
        SMS::for($verification->mobile)
            ->template('verify')
            ->setFirstToken($verification->code)
            ->sendLookUp();
    }
}
