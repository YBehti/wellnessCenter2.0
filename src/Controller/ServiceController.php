<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Service;
use App\Form\CommentType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function index(PaginatorInterface $paginator,Request $request){




        $repository = $this->getDoctrine()->getRepository(Service::class);
        $services = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            4

        ) ;

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

    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(Service::class);
        $services = $repository->findAll();


        return $this->render('service/list.html.twig', [
            'services' => $services,
        ]);

    }
}
