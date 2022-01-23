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

    #[Route('/page/{param1}/{param2}', name: 'page-with-param')]
    public function pageWithParam($param1, $param2)
    {
        $result = $param1 * $param2;
        return $this->render('standard/page.html.twig', [
            'param1' => $param1,
            'param2' => $param2,
            'result' => $result
        ]);
    }

    #[Route('/redirect-to-page', name: 'redirect-to-page')]
    public function redirectToPage()
    {
        return $this->redirectToRoute('page');
    }

    #[Route('/redirect-to-page-with-param/{id}/{name}', name: 'redirect-to-page-with-param')]
    public function redirectToPageWithParam($id, $name)
    {
        dump($id);
        dump($name);
        return $this->redirectToRoute('page-with-param', ['param1' => $id, 'param2' => $name]);
    }
}
