<?php
require_once '../vendor/swiftmailer/swiftmailer/lib/swift_required.php';

class Mailer{

    public function sendMessage($to,$subject,$corp){
        try{
            $from= array('ncornec@neuf.fr'=>'Gîtes St Jean de Monts');

            $transport = Swift_SmtpTransport::newInstance('smtp.sfr.fr', 25)
                ->setUsername('ncornec@neuf.fr')
                ->setPassword('h4qvz4j6')
            ;

            $mailer = Swift_Mailer::newInstance($transport);

            $message = Swift_Message::newInstance($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($corp, 'text/html')
            ;

            $mailer->send($message);
        }
        catch (\Exception $e){
            var_dump($e->getMessage());
        }
    }

}