<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{

    public function index($name, \Swift_Mailer $mailer,$mail,$tokken)
    {
        $message = (new \Swift_Message('Wellness Center'))
            ->setFrom('noreply@wellness')
            ->setTo($mail)
            ->setBody(
                $this->renderView(

                    'email/registration.html.twig',
                    array('name' => $name,
                        'tokken'=>$tokken)
                ),
                'text/html'
            )

        ;

        $mailer->send($message);

        return $this->render('profile/redirect.html.twig',[
            'email'=>$mail
        ]);
    }
}
