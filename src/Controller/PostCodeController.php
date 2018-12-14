<?php

namespace App\Controller;

use App\Entity\PostCode;
use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostCodeController extends AbstractController
{


    public function list(){

        $repository = $this->getDoctrine()->getRepository(PostCode::class);
        $post_codes = $repository->findAll();

        return $this->render('postCode/list.html.twig', [
            'post_codes' => $post_codes,
        ]);

    }
}
