<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StandardController extends AbstractController
{
    #[Route('/', name: 'standard')]
    public function index(): Response
    {
        return $this->render('standard/index.html.twig', [
            'controller_name' => 'Hello Symfony 🎶',
        ]);
    }

    #[Route('/page', name: 'page')]
    public function page()
    {
        return $this->render('standard/page.html.twig');
    }

    #[Route('/redirect-to-page', name: 'redirect-to-page')]
    public function redirectToPage() {
        return $this->redirectToRoute('page');
    }

    #[Route('/redirect-to-page-with-param/{id}/{name}', name: 'redirect-to-page-with-param')]
    public function redirectToPageWithParam($id, $name) {
        dump($id);
        dump($name);
        return $this->redirectToRoute('page', ['id' => $id, 'name' => $name]);
    }
}
