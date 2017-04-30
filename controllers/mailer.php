<?php
require_once '../vendor/swiftmailer/swiftmailer/lib/swift_required.php';

$from='contact@stjeandemonts.fr';
$to='robin.cornec@laposte.net';
$subject='test';
$corp='test';
//$this->sendMessage('contact@stjeandemonts.fr','robin.cornec@laposte.net','test','test');

//public function sendMessage($from,$to,$subject,$corp){
    $transport = Swift_SmtpTransport::newInstance('localhost', 25);

    $mailer = Swift_Mailer::newInstance($transport);
    
    $message = Swift_Message::newInstance()
        // Give the message a subject
        ->setSubject($subject)
        // Set the From address with an associative array
        ->setFrom($from)
        // Set the To addresses with an associative array
        ->setTo($to)
        // Give it a body
        ->setBody($corp)
    ;

    $numSent = $mailer->send($message);

    if ($mailer->send($message))
    {
        return true;
    }
    else
    {
        return false;
    }
//}