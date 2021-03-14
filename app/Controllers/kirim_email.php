<?php

namespace App\Controllers;

use App\Models\Email;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Kirim_email extends BaseController
{
    private $email;
    public function __construct()
    {
        $this->email = new Email();
        helper(['form']);
    }

    public function index()
    {
        $data = $this->email->getEmail(date("Y-m-d H:i:s"));
        $this->send($data);

        return view('front');
    }

    public function send($emails)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'smtp.googlemail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'aldisaep@upi.edu'; // silahkan ganti dengan alamat email Anda
            $mail->Password   = 'aldi5aep'; // silahkan ganti dengan password email Anda
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('aldisaep@upi.edu', 'Test email'); // silahkan ganti dengan alamat email Anda
            // $mail->addReplyTo('aldisaepuraha@upi.edu', 'Test email'); // silahkan ganti dengan alamat email Anda

            foreach ($emails as $data) {
                $mail->addAddress($data['email']);
                // Content
                $mail->isHTML(true);
                $mail->Subject = $data['subject'];
                $mail->Body    = $data['isi_email'];
    
                $mail->send();
            }
            session()->setFlashdata('success', 'Send Email successfully');
        } catch (Exception $e) {
            session()->setFlashdata('error', "Send Email failed. Error: " . $mail->ErrorInfo);
        }
    }
}
