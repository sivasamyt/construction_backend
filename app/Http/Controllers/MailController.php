<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Mail;
use App\Mail\OtpMail;

class MailController extends Controller
{
    public function otpMail(Request $request)
    {
        // return $request->email;
        $emailId = $request->email;
        $otp = random_int(100000, 999999);
        // $data = $otp;
        try {
            Mail::to($emailId)->send(new OtpMail($otp));
            return response()->json(['message' => 'please check mail']);
        } catch (Exception $th) {
            return response()->json(['message'=> 'Mail not send verify mail id please']);
        }

    }


}
