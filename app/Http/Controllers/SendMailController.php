<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
class SendMailController extends Controller
{
    public function index(){
        $mailData=[
            'title'=>'Ghansham Soomarani',
            'body' =>'This mail is for testing purpuse'
        ];
        Mail::to('ghanshamlsoomarani@gmail.com')->send(new SendMail($mailData));
        echo"<h1>Emailsend successfully!!</h1>";
    }
    //
}
