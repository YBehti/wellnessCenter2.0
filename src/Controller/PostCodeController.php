<?php

namespace App\Controller;

use App\Entity\PostCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
