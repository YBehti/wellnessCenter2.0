<?php

namespace App\Controller;



use App\Entity\Provider;
use App\Entity\Surfer;
use App\Entity\TempUser;


use App\Form\ProviderFormType;
use App\Form\SurferFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Services\Mailer;


class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function index()
    {
        return $this->render('profile/register.html.twig', [
            'controller_name' => 'SecurityController',
        ]);

    }

    /**
     * @Route("/registered", name="registered")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    function registered(Request $request,ObjectManager $manager,Mailer $mailer){

        $getType = $request->get('user_type');
        $getEmail = $request->get('email');
        $getPassword = $request->get('password');
        $token = (hash('sha256',$getEmail));





        $tempUser = new TempUser();
        $tempUser->setEmail($getEmail);
        $tempUser->setUserType($getType);
        $tempUser->setPassword($getPassword);
        $tempUser->setToken($token);

        $manager->persist($tempUser);

        $manager->flush();





        $mailer->SendMail($getEmail,$token,$getType);

        return $this->render('profile/redirect.html.twig',[
            'email'=>$getEmail
        ]);
    }


    /**
     * @Route ("/complete_subscribe/{type}/{token}", name="complete_subscribe")
     *
     */

    function complete_registration($token,$type, Request $request){



        switch ($type){

            case 'surfer':
                $surfer = new Surfer();
                $surfer
                    ->setBanned(false)
                    ->setConnectionFailed(0)
                    ->setRegistrationDate(new \DateTime())
                    ->setRoles(['ROLE_USER']);
                $user = $surfer;
                $form = $this->createForm(SurferFormType::class,$user);
                break;
            case 'provider':
                $provider = new Provider();
                $provider
                    ->setBanned(false)
                    ->setConnectionFailed(0)
                    ->setRegistrationDate(new \DateTime())
                    ->setRoles(['ROLE_VENDOR']);
                $user = $provider;
                $form = $this->createForm(ProviderFormType::class,$user);
                break;
        }



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $password = $form->get('password')->getData();
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $password

            ));
            $manager->persist($user);
            $manager->flush();
            $tempUser = $this->getDoctrine()->getRepository(TempUser::class)
           ->findOneBy([
               'token'=>$token
           ]);
            $cleaner = $this->getDoctrine()->getManager();
            $cleaner->remove($tempUser);
            $manager->flush();



            return $this->redirectToRoute('login');
        }
        return $this->render('profile/registration_form.html.twig',[

            'form'=>$form->createView()

        ]);

    }













}
