<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MailClass;
use Illuminate\Support\Facades\Mail;

class MailSetting extends Controller
{
    public function sendMail(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $msg = $request->msg;

        Mail::to('ololo@gmail.com')->send(new MailClass($name, $email, $msg));
        return redirect()->back();
    }

}
