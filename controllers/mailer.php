<?php
require_once './vendor/swiftmailer/swiftmailer/lib/swift_required.php';

$from= array('contact@stjeandemonts.fr'=>'on sen fou');
$to= array('robin.cornec@laposte.net'=>'on sen fou');
$subject='test';
$corp='test';
//$this->sendMessage('contact@stjeandemonts.fr','robin.cornec@laposte.net','test','test');

//public function sendMessage($from,$to,$subject,$corp){
    $transport = Swift_SmtpTransport::newInstance('localhost', 25);

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance($subject)
        ->setFrom($from)
        ->setTo($to)
        ->setBody($corp)
    ;

    $numSent = $mailer->send($message);

    if ($mailer->send($message))
    {
        echo 'envoyé \n';
    }
    else
    {
        echo 'erreur \n';
    }
//}