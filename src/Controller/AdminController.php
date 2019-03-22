<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Provider;
use App\Entity\Service;
use App\Form\ProviderFormType;
use App\Form\ServiceType;
use App\Services\Mailer;
use App\Services\UploaderHelper;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController


{



    // Display all the providers

    /**
     * @Route("/admin", name="admin")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {

        return $this->redirectToRoute('provider');
    }

    // Get one provider by slug

    public function get_provider($slug){

        $repository = $this->getDoctrine()->getRepository(Provider::class);
        $provider = $repository->findOneBy(['slug'=>$slug]);

        return $provider;
    }



    // Provider's update by an admin

    /**
     * @Route("/admin/provider/update/{slug}", name="provider_update")
     */
    public function update_provider($slug, Request $request){

       $provider = $this->get_provider($slug);
       $user_type = 'provider';
       $form = $this->createForm(ProviderFormType::class,$provider);
       $form->remove('password');
       $form->remove('confirm_password');
       $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->flush();

            return $this->render('provider/detail.html.twig',[

                'provider'=> $provider,

            ]);
        }

       return $this->render('profile/profile_form.html.twig',[

           'form'=>$form->createView(),
           'user_type'=>$user_type

       ]);
    }



    // Update a service

    /**
     * @Route ("/update_service/{slug}", name="update_service")
     */

    public function update_service(Request $request,$slug,UploaderHelper $uploaderHelper){

        $repository = $this->getDoctrine()->getRepository(Service::class);
        $service = $repository->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $uploadedVitrine = $form['vitrine_picture']->getData();

            if ($uploadedVitrine)
            {

                $newFileName = $uploaderHelper->uploadImage($uploadedVitrine);


                $image = new Image();
                $image
                    ->setImage($newFileName)
                    ->setType('vitrine')
                    ->setOrdre(1);
                $manager->persist($image);
                $service->setVitrine($image);
            }



            $manager->flush();

            return $this->redirectToRoute("service");
        }

        return $this->render("service/service_form.html.twig",[
            'form'=>$form->createView(),
            'service'=>$service
        ]);

    }

    // Delete a service


    /**
     * @Route("delete_service/{slug}", name="delete_service")
     */
    public function delete_service($slug){

        $repository = $this->getDoctrine()->getRepository(Service::class);
        $service = $repository->findOneBy(['slug'=>$slug]);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($service);
        $manager->flush();

        return $this->redirectToRoute("service");


    }



    /**
     * @Route("/add_service", name="admin_add_service")
     */
    public function add(Request $request,UploaderHelper $uploaderHelper){
        $service = new Service();



        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $uploadedVitrine = $form['vitrine_picture']->getData();

            if ($uploadedVitrine)
            {

                $newFileName = $uploaderHelper->uploadImage($uploadedVitrine);


                $image = new Image();
                $image
                    ->setImage($newFileName)
                    ->setType('vitrine')
                    ->setOrdre(1);
                $manager->persist($image);
                $service->setVitrine($image);
            }
            $manager->persist($service);
            $manager->flush();
            return $this->redirectToRoute('service');
        }
        return $this->render('service/service_form.html.twig', [


            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/ban/{slug}", name="banned")
     */
    public function setBanned($slug,Mailer $mailer){
        $repository = $this->getDoctrine()->getRepository(Provider::class);
        $provider = $repository->findOneBy(['slug'=>$slug]);

        $provider->setBanned(true);
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();


        $email = $provider->getEmail();


        $mailer->SendMail($email,'banned',['email'=>$email]);

        return $this->redirectToRoute("provider");


    }




}
