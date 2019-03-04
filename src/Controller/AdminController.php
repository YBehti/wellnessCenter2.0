<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Entity\Service;
use App\Form\ProviderFormType;
use App\Form\ServiceType;
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

           'form'=>$form->createView()

       ]);
    }



    // Update a service

    /**
     * @Route ("/update_service/{slug}", name="update_service")
     */

    public function update_service(Request $request,$slug){

        $repository = $this->getDoctrine()->getRepository(Service::class);
        $service = $repository->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->flush();

            return $this->redirectToRoute("service-detail");
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
    public function add(Request $request){
        $service = new Service();



        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($service);
            $manager->flush();
            return $this->redirectToRoute('service');
        }
        return $this->render('service/service_form.html.twig', [


            'form' => $form->createView()
        ]);
    }

}
