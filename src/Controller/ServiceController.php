<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Service::class);
        $services = $repository->findAll();

        return $this->render('service/index.html.twig', [
            'services' => $services,
        ]);
    }

    /**
     * @Route("/service/{id}", name="service-detail")
     */
    public function detail($id)
    {
        $repository = $this->getDoctrine()->getRepository(Service::class);
        $service = $repository->find($id);

        return $this->render('service/detail.html.twig', [
            'service' => $service,
        ]);
    }

    public function list(){

        $repository = $this->getDoctrine()->getRepository(Service::class);
        $services = $repository->findAll();

        return $this->render('service/list.html.twig', [
            'services' => $services,
        ]);

    }
}
