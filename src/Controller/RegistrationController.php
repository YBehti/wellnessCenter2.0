<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Entity\TempUser;
use App\Form\ProviderFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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

    function registered(Request $request,ObjectManager $manager,\Swift_Mailer $mailer){

        $getType = $request->get('user_type');
        var_dump($getType);
        $getEmail = $request->get('email');
        var_dump($getEmail);
        $getPassword = $request->get('password');
        var_dump($getPassword);
        $token = (hash('sha256',$getEmail));





        $tempUser = new TempUser();
        $tempUser->setEmail($getEmail);
        $tempUser->setUserType($getType);
        $tempUser->setPassword($getPassword);
        $tempUser->setToken($token);

        $manager->persist($tempUser);

        $manager->flush();





        $message = (new \Swift_Message('Wellness Center'))
            ->setFrom('noreply@wellness')
            ->setTo($getEmail)
            ->setBody(
                $this->renderView(

                    'email/registration.html.twig',
                    array('email' => $getEmail,
                        'token'=>$token,
                        'type'=>$getType)
                ),
                'text/html'
            )

        ;

        $mailer->send($message);

        return $this->render('profile/redirect.html.twig',[
            'email'=>$getEmail
        ]);
    }


    /**
     * @Route ("/complete_subscribe/{type}/{token}", name="complete_subscribe")
     *
     */

    function complete_registration($token,$type, Request $request){

        $user = $this->getDoctrine()->getRepository(TempUser::class)
            ->findOneBy([
                'token'=>$token
            ]);

        switch ($type){

            case 'surfer':
                return $this->render('profile/user_registration.html.twig',[

                    'user'=>$user

                ]);
                break;
            case 'provider':
                $provider = new Provider();
                $provider
                    ->setBanned(false)
                    ->setConnectionFailed(0)
                    ->setRegistrationDate(new \DateTime());

                $form = $this->createForm(ProviderFormType::class);
                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()){
                    $manager = $this->getDoctrine()->getManager();
                    $password = $form->get('password')->getData();
                    $provider->setPassword($this->passwordEncoder->encodePassword(
                        $provider,
                        $password

                    ));
                    $manager->persist($provider);
                    $manager->flush();

                    return $this->redirectToRoute('service');
                }
                return $this->render('profile/provider_registration.html.twig',[
                    'form'=>$form->createView()
                ]);

                break;
        }







    }



















}
