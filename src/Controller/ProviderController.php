<?php

namespace App\Controller;

use App\Entity\Provider;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProviderController extends AbstractController
{
    /**
     * @Route("/provider", name="provider")
     */
    public function index(PaginatorInterface $paginator,Request $request){




        $repository = $this->getDoctrine()->getRepository(Provider::class);
        $providers = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            4

        ) ;


        return $this->render('provider/index.html.twig', [
            'providers' => $providers,

        ]);
    }

    /**
     * @Route("/provider/{id}", name="provider-detail")
     */

    public function detail($id){
        $repository = $this->getDoctrine()->getRepository(Provider::class);
        $provider = $repository->find($id);

        return $this->render('provider/detail.html.twig',[
            'provider'=> $provider,
        ]);
    }

    public function list(){

        $repository = $this->getDoctrine()->getRepository(Provider::class);
        $providers = $repository->findAll();



        return $this->render('provider/list.html.twig', [
            'providers' => $providers,

        ]);

    }
}
