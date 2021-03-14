<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Kirim_email extends BaseController
{
    public function __construct()
    {
        helper(['form']);
    }

    public function index()
    {
        return view('v_form_kirim_email');
    }

    public function send()
    {
        $to                 = $this->request->getPost('to');
        $subject             = $this->request->getPost('subject');
        $message             = $this->request->getPost('message');

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'smtp.googlemail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'rifkymr@upi.edu'; // silahkan ganti dengan alamat email Anda
            $mail->Password   = 'SL(starlight)'; // silahkan ganti dengan password email Anda
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('rifkymr@upi.edu', 'Test email'); // silahkan ganti dengan alamat email Anda
            $mail->addAddress($to);
            $mail->addReplyTo('rifkymr@upi.edu', 'Test email'); // silahkan ganti dengan alamat email Anda
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            session()->setFlashdata('success', 'Send Email successfully');
            return redirect()->to('/kirim_email');
        } catch (Exception $e) {
            session()->setFlashdata('error', "Send Email failed. Error: " . $mail->ErrorInfo);
            return redirect()->to('/kirim_email');
        }
    }
}
