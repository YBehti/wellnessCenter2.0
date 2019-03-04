<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Entity\Surfer;
use App\Form\ProviderFormType;
use App\Form\SurferFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function form_update_view(UserInterface $user,Request $request)
    {
        if($user instanceof Surfer){
            $form = $this->createForm(SurferFormType::class, $user);

        }elseif($user instanceof Provider){
            $form = $this->createForm(ProviderFormType::class, $user);

        }

        $form->remove('password');
        $form->remove('confirm_password');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->flush();


            $this->redirectToRoute('profile');

        }


        return $this->render('profile/profile_form.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
