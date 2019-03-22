<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 3/21/2019
 * Time: 4:01 PM
 */

namespace App\Event;

use App\Entity\User;
use App\Services\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LoginListener implements EventSubscriberInterface
{

    protected $em;
    protected $sendMails;

    public function __construct(EntityManagerInterface $entityManager, Mailer $sendMails)
    {
        $this->em = $entityManager;
        $this->sendMails = $sendMails;
    }

    /**
     * @return array
     */

    public static function getSubscribedEvents()
    {
       return [
           AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure'
       ];
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event){
        $attemptLimit = 4;
        $lastUser = $event->getAuthenticationToken()->getUser();
        $repository = $this->em->getRepository(User::class);
        $user = $repository->findOneBy(['email' => $lastUser]);
        if($user){
            if ($user->getBanned()!== true){
                $connexionAttempt = $user->getConnectionFailed();
                if ($connexionAttempt < $attemptLimit){
                    $connexionAttempt = ($connexionAttempt === null || $connexionAttempt === 0)?1:$connexionAttempt+1;
                    $user->setConnectionFailed($connexionAttempt);
                    $this->em->persist($user);
                    $this->em->flush();
                }
                if($connexionAttempt === $attemptLimit){
                    $this->sendMails->SendMail($lastUser,'attemptLimit',['email'=>$lastUser]);
                    $message = "Vous avez dépassez le nombre maximum d'essaie";

                }
                else {
                    $message = "Il vous reste: ".($attemptLimit - $connexionAttempt);
                }
                throw new CustomUserMessageAuthenticationException($message);
            }else{
                throw new CustomUserMessageAuthenticationException("Your account has been Banned");
            }
        }else{
            throw new CustomUserMessageAuthenticationException("This user isn't registered");

        }
    }
}