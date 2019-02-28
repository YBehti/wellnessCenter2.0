<?php

namespace App\Controller;

use Doctrine\ORM\Repository\RepositoryFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Internship;
use App\Form\InternshipFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class InternshipController extends AbstractController
{
    /**
     * @Route ("/add_internship", name="add_internship")
     */

    public function add_internship( Request $request)
    {
        $internship = new Internship();
        $user = $this->getUser();
        $internship->setProvider($user);
        $form = $this->createForm(InternshipFormType::class, $internship);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($internship);
            $manager->flush();

            return $this->redirectToRoute('profile');
        }
        return $this->render('internship/form_internship.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/internship_update/{slug}", name="update_internship")
     */

    public function update_internship(Request $request,$slug){

        $repository = $this->getDoctrine()->getRepository(Internship::class);
        $internship = $repository->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(InternshipFormType::class, $internship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->flush();

            return $this->redirectToRoute("profile");
        }

        return $this->render("internship/form_internship.html.twig",[
            'form'=>$form->createView(),
            'internship'=>$internship
        ]);

    }
    /**
     * @Route("/internship_delete/{slug}", name="delete_stage")
     */
    public function delete_internship($slug){

        $repository = $this->getDoctrine()->getRepository(Internship::class);
        $internship = $repository->findOneBy(['slug'=>$slug]);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($internship);
        $manager->flush();

        return $this->redirectToRoute("profile");


    }
}
