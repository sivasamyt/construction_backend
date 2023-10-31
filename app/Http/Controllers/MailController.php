<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    public function otpMail()
    {
        $otp = random_int(100000, 999999);
        return $otp;
    }


}
