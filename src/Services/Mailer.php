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

    public function SendMail($email,$template,$datas){
        $message = (new \Swift_Message('Wellness Center'))
            ->setFrom('behti90@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->templating->render("email/$template.html.twig",

                    $datas




                ),
                'text/html'
            )

        ;

        $this->mailer->send($message);


    }



}

