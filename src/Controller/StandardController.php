<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StandardController extends AbstractController
{
    #[Route('/standard', name: 'standard')]
    public function index(): Response
    {
        return $this->render('standard/index.html.twig', [
            'controller_name' => 'Hello Symfony 🎶',
        ]);
    }
}
