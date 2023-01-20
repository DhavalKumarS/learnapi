<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send()
    {
        $data = ['name'=> 'dhaval','data'=> 'hello Dhaval'];
        $user['to']= 'supertradergrow@gmail.com';
        Mail::send('mail', $data, function ($message) use ($user) {
            // $message->from('john@johndoe.com', 'John Doe');
            // $message->sender('john@johndoe.com', 'John Doe');
            $message->to($user['to'],);
            // $message->cc('john@johndoe.com', 'John Doe');
            // $message->bcc('john@johndoe.com', 'John Doe');
            // $message->replyTo('john@johndoe.com', 'John Doe');
            $message->subject('Subject');
            // $message->priority(3);
            // $message->attach('pathToFile');
        });
    }
}
