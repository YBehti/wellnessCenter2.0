<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Entity\Service;
use App\Form\ServiceType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController


{






    /**
     * @Route("/admin", name="admin")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Provider::class);
        $providers = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10

        ) ;
        return $this->render('admin/providers.html.twig', [
            'providers' => $providers,
        ]);
    } /**
     * @Route("/admin_services", name="admin_services")
     */
    public function service(PaginatorInterface $paginator, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Service::class);
        $services = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10

        ) ;
        return $this->render('admin/services.html.twig', [
            'services' => $services,
        ]);
    }
    /**
     * @Route("/admin/service/{slug}", name="service_admin_detail")
     */

    public function detail($slug, Request $request){





        $repository = $this->getDoctrine()->getRepository(Service::class);
        $service = $repository->findOneBy(['slug'=>$slug]);





        return $this->render('admin/service_detail.html.twig',[

            'service'=> $service,

        ]);
    }
    /**
     * @Route("/admin/provider/{slug}", name="provider_admin_detail")
     */

    public function detail_provider($slug, Request $request){





        $repository = $this->getDoctrine()->getRepository(Provider::class);
        $provider = $repository->findOneBy(['slug'=>$slug]);





        return $this->render('admin/provider_detail.html.twig',[

            'provider'=> $provider,

        ]);
    }
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

            return $this->redirectToRoute("admin_services");
        }

        return $this->render("admin/service_update.html.twig",[
            'form'=>$form->createView(),
            'service'=>$service
        ]);

    }

    /**
     * @Route("delete_service/{slug}", name="delete_service")
     */
    public function delete_service($slug){

        $repository = $this->getDoctrine()->getRepository(Service::class);
        $service = $repository->findOneBy(['slug'=>$slug]);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($service);
        $manager->flush();

        return $this->redirectToRoute("admin_services");


    }

    /**
     * @Route("/admin_add_service", name="admin_add_service")
     */
    public function add(Request $request){
        $service = new Service();



        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($service);
            $manager->flush();

            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/add_service.html.twig', [

            'form' => $form->createView()
        ]);
    }

}
