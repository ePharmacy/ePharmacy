<?php

require_once dirname(__FILE__).'/../../vendor/autoload.php';
require_once dirname(__FILE__).'/../config.php';

class SMTPClient {

    private $mailer;

    public function __construct() {

            // Create the Transport
           $transport = (new Swift_SmtpTransport(Config::SMTP_HOST, Config::SMTP_PORT))
           ->setUsername(Config::SMTP_USER)
           ->setPassword(Config::SMTP_PASSWORD)
           ;
           
           // Create the Mailer using your created Transport
           $this->mailer = new Swift_Mailer($transport);
    }

    public function send_register_user_token($admin) {

        // Create a message
        $message = (new Swift_Message('Confirm your account'))
        ->setFrom(['sadulah.tahirovic@stu.ibu.edu.ba' => 'egym'])
        ->setTo([$admin['email']])
        ->setBody('Here is the confirmation link: http://localhost/egym/api/admins/confirm/'.$admin['token']);
        ;
        
        // Send the message
       $this->mailer->send($message);
    }

    public function send_user_recovery_token($admin) {
        // Create a message
        $message = (new Swift_Message('Reset your password'))
        ->setFrom(['sadulah.tahirovic@stu.ibu.edu.ba' => 'egym'])
        ->setTo([$admin['email']])
        ->setBody('Here is the recovery token: '.$admin['token']);
        ;
        
        // Send the message
       $this->mailer->send($message);
    }
}

        
        

?>