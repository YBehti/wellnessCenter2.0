<?php

namespace App\Controller;

use App\Entity\Provider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
       $getCp = $request->get('locality');
//       var_dump($getCp);
       $getService = $request->get('service');
//       var_dump($getService);
       $getProvider = $request->get('provider');
//       var_dump($getProvider);

       $repository = $this->getDoctrine()->getRepository(Provider::class);
       $providers = $repository->findByCp($getCp,$getService,$getProvider);



       return $this->render('/search/results.html.twig',[
           'providers'=>$providers
       ]);
    }
}
