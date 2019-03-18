<?php

namespace App\Controller;

use App\Entity\Provider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request,PaginatorInterface $paginator)
    {



       $getCp = $request->get('locality');
       $getService = $request->get('service');
       $getProvider = $request->get('provider');

       $query = ['locality'=>$getCp, 'service'=>$getService, 'provider'=>$getProvider];

       $repository = $this->getDoctrine()->getRepository(Provider::class);
       $providers = $paginator->paginate(
           $repository->findByCp($getCp,$getService,$getProvider),
           $request->query->getInt('page', 1),
           4
       );




       return $this->render("provider/index.html.twig",[
           'providers'=>$providers,
           'query'=>$query
       ]);
    }
}
