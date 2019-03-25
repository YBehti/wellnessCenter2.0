<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Provider;
use App\Entity\Surfer;
use App\Form\ProviderFormType;
use App\Form\SurferFormType;
use App\Services\UploaderHelper;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{

    /**
     * @Route ("/profile", name="profile")
     */
    public function show_profile(UserInterface $user)
    {

        return $this->render('profile/profile_view.html.twig',[
            'user'=>$user]);

    }


    /**
     * @Route ("/profile_update", name="profile_update")
     */
    public function form_update_view(UserInterface $user,Request $request,UploaderHelper $uploaderHelper)
    {
        if($user instanceof Surfer){
            $userType = 'surfer';
            $form = $this->createForm(SurferFormType::class, $user);

        }elseif($user instanceof Provider){
            $userType = 'provider';
            $form = $this->createForm(ProviderFormType::class, $user);

        }

        $form->remove('password');
        $form->remove('confirm_password');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $uploadedProfile = $form['profile_picture']->getData();



            if ($uploadedProfile)
            {

                $newFileName = $uploaderHelper->uploadImage($uploadedProfile);


                $image = new Image();
                $image
                    ->setImage($newFileName)
                    ->setType('profile')
                    ->setOrdre(1);
                $manager->persist($image);
                $user->addImage($image);
            }

            if ($userType === 'provider')
            {
                $uploadedLogo = $form['logo_picture']->getData();

                if ($uploadedLogo)
                {

                    $newFileName = $uploaderHelper->uploadImage($uploadedLogo);


                    $image = new Image();
                    $image
                        ->setImage($newFileName)
                        ->setType('logo')
                        ->setOrdre(1);
                    $manager->persist($image);
                    $user->addImage($image);
                }
            }





            $manager->flush();


            return $this->redirectToRoute('profile');

        }


        return $this->render('profile/profile_form.html.twig', [
            'form' => $form->createView(),
            'user_type'=>$userType

        ]);
    }



}
