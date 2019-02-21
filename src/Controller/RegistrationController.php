<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Internship;
use App\Entity\Provider;
use App\Entity\Surfer;
use App\Entity\TempUser;
use App\Form\ImageType;
use App\Form\InternshipFormType;
use App\Form\ProviderFormType;
use App\Form\SurferFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


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
                $surfer = new Surfer();
                $surfer
                    ->setBanned(false)
                    ->setConnectionFailed(0)
                    ->setRegistrationDate(new \DateTime());


                $form = $this->createForm(SurferFormType::class,$surfer);
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()){
                    $manager = $this->getDoctrine()->getManager();
                    $password = $form->get('password')->getData();
                    $surfer->setPassword($this->passwordEncoder->encodePassword(
                        $surfer,
                        $password

                    ));
                    $manager->persist($surfer);
                    $manager->flush();

                    return $this->redirectToRoute('service');
                }
                return $this->render('profile/surfer_registration.html.twig',[

                    'form'=>$form->createView()

                ]);
                break;
            case 'provider':
                $provider = new Provider();
                $provider
                    ->setBanned(false)
                    ->setConnectionFailed(0)
                    ->setRegistrationDate(new \DateTime());

                $form = $this->createForm(ProviderFormType::class,$provider);
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

                    return $this->redirectToRoute('login');
                }
                return $this->render('profile/provider_registration.html.twig',[
                    'form'=>$form->createView()
                ]);

                break;
        }







    }

   /* /**
     * @Route ("/profile_picture", name="profile_picture")
     */

    /*public function uploadImage(Request $request){
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $file = $image->getImage();
            $fileName = md5(uniqid().'.'.$file->guessExtension);
            $file->move($this->getParameter('profile_img_directory'),$fileName);
            $image->setImage($fileName);

           return $this->redirectToRoute('service');
        }
        return $this->render('profile/image.html.twig',[
            'form'=>$form->createView()
        ]);
    }*/
    /**
     * @Route ("/profile", name="profile")
     */
    public function show_profile(UserInterface $user)
    {
        if($user instanceof Provider){

            return $this->render('profile/profile_provider.html.twig',[
                'user'=>$user]);
        }elseif ($user instanceof Surfer){
            return $this->render('profile/profile_surfer.html.twig',[
                'user'=>$user
            ]);
        }


    }
    /**
     * @Route ("/profile_update", name="profile_update")
     */
    public function form_update_view(UserInterface $user,Request $request)
    {
        if($user instanceof Surfer){
            $form = $this->createForm(SurferFormType::class, $user);

            $type = 'surfer';
        }elseif($user instanceof Provider){
            $form = $this->createForm(ProviderFormType::class, $user);
            $type = 'provider';
        }

        $form->remove('password');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->flush();




        }
        dump($this->getUser());

        return $this->render('profile/'. $type .'_edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }







}
