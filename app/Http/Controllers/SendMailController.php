<?php

namespace App\Http\Controllers;

use App\Mail\SendApiNotificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
class SendMailController extends Controller
{
    public function sendMail(Request $request)
    {
        // Laravel 8
        // $data["email"] = "test@gmail.com";
        // $data["title"] = "Techsolutionstuff";
        // $data["body"] = "This is test mail with attachment";

        // $files = [
        //     public_path('attachments/test_image.jpeg'),
        //     public_path('attachments/test_pdf.pdf'),
        // ];

        // Mail::send('mail.test_mail', $data, function($message)use($data, $files) {
        //     $message->to($data["email"])
        //             ->subject($data["title"]);

        //     foreach ($files as $file){
        //         $message->attach($file);
        //     }
        // });
        $mailData = [
            'title' => 'This is Test Mail',
            'files' => [
                public_path('attachments/test_image.jpeg'),
                public_path('attachments/test_pdf.pdf'),
            ]
        ];

        Mail::to('yencrush872@gmail.com')->send(mailable: new SendApiNotificationEmail());

        return "Mail send successfully !!";
    }
}
