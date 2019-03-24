<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 3/24/2019
 * Time: 4:20 PM
 */

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class UserControl implements UserCheckerInterface
{
    protected $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    public function checkPreAuth(UserInterface $user)
    {

        if($user->getBanned() == true){
            throw new CustomUserMessageAuthenticationException("Your account has been Banned");
        }

        if($user-> getConnectionFailed() >= 4){
            throw new CustomUserMessageAuthenticationException('You have reached the limited connexion attempt');
        }
    }
    public function checkPostAuth(UserInterface $user)
    {


        $user->setConnectionFailed(0);
        $this->em->persist($user);
        $this->em->flush();
    }
}