<?php

namespace App\Services;

use Twig\Environment;

class Mailer{

    private $mailer;
    private $templating;


    public function __construct(\Swift_Mailer $mailer,Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;

    }

    public function SendMail($email,$token,$type){
        $message = (new \Swift_Message('Wellness Center'))
            ->setFrom('noreply@wellness.com')
            ->setTo($email)
            ->setBody(
                $this->templating->render('email/registration.html.twig',[

                    'email' => $email,
                    'token'=>$token,
                    'type'=>$type

                ]

                ),
                'text/html'
            )

        ;

        $this->mailer->send($message);


    }
    public function SendBannedEmail($email){
        $message = (new \Swift_Message('Wellness Center'))
            ->setFrom('noreply@wellness.com')
            ->setTo($email)
            ->setBody(
                $this->templating->render('email/banned.html.twig',[
                    'email'=>$email
                ]),
                'text/html'
            );
        $this->mailer->send($message);
    }


}

