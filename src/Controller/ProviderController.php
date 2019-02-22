<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Provider;
use App\Form\CommentType;
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
     * @Route("/provider/{slug}", name="provider_detail")
     */

    public function detail($slug, Request $request){




        $user=$this->getUser();
        $repository = $this->getDoctrine()->getRepository(Provider::class);
        $provider = $repository->findOneBy(['slug'=>$slug]);

        $comment = new Comment();
        $form =$this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $comment->setProvider($provider);
            $comment->setSurfer($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();
        }



        return $this->render('provider/detail.html.twig',[

            'provider'=> $provider,

            'form'=> $form->createView()
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
