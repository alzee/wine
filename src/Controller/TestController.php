<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\NodeType;
use App\Entity\Node;
use Doctrine\Persistence\ManagerRegistry;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $node = new Node();
        $form = $this->createForm(NodeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            // ... perform some action, such as saving the task to the database
            $node = $form->getData();
            dump($node);
            $em = $doctrine->getManager();
            $em->persist($node);
            $em->flush();

        }

        return $this->renderForm('test/index.html.twig', [
            'controller_name' => 'TestController',
            'form' => $form
        ]);
    }
}
