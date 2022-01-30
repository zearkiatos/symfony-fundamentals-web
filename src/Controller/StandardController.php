<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StandardController extends AbstractController
{

    #[Route('/', name: 'standard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // $category = new Category('Clothes');
        // $entityManager->persist($category);
        // $entityManager->flush();
        // $search = $entityManager->getRepository(Category::class)->find(1);
        // $search->setName('Technology 2');
        // $entityManager->flush();
        $search = $entityManager->getRepository(Category::class)->find(1);
        $entityManager->remove($search);
        $entityManager->flush();
        return $this->render('standard/index.html.twig', [
            'controller_name' => 'Hello Symfony 🎶',
            'search'=>$search
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
