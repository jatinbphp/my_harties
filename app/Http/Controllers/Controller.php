<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function fileMove($photo, $path){
        $root = public_path('uploads/'.$path);
        $filename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
        $name = $filename."_".date('His',time()).".".$photo->getClientOriginalExtension();
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        $photo->move($root,$name);
        return 'public/uploads/'.$path."/".$name;
    }

    public function sendMail($mail_data, $subject, $template,$from = null){
        $data['data'] = $mail_data;
        $email = $mail_data['email'];
        \Mail::send('mail_template/'.$template,(array)$data, function($message) use ($email, $subject, $from, $mail_data) {
            $message->from($mail_data['email']);
            $message->to('info@mytownonline.app');
            $message->subject($subject);
        });
        return 1;
    }
}

