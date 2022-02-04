<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\ExampleType;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Exception;

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
        // $search = $entityManager->getRepository(Category::class)->find(1);
        // $entityManager->remove($search);
        // $entityManager->flush();
        // $category = $entityManager->getRepository(Category::class)->find(2);
        $category = $entityManager->getRepository(Category::class)->search('food');
        // $product = new Product("Burgers","0789", $category);
        // $entityManager->persist($product);
        // $entityManager->flush();
        return $this->render('standard/index.html.twig', [
            'controller_name' => 'Hello Symfony 🎶',
            'search' => $category
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


    #[Route('/category-page', name: 'category')]
    public function categoryPage()
    {
        $category = new Category('Name');
        $formCategory = $this->createForm(CategoryType::class, $category);

        return $this->render("standard/category.html.twig", [
            'formCategory' => $formCategory->createView()
        ]);
    }

    #[Route('/product-page', name: 'product')]
    public function productPage(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $product = new Product('', '');
        $formProduct = $this->createForm(ProductType::class, $product);
        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid()) {
            $photo = $formProduct->get('photo')->getData();
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();
                $product->setPhoto($newFilename);
                try {
                    $photo->move($this->getParameter(('photos_directory')), $newFilename);
                    $entityManager->persist($product);
                    $entityManager->flush();
                } catch (FileException $exception) {
                    throw new Exception(("Ups something was wrong"));
                }
            }

            $this->addFlash('Success', 'The data was save successfully');
            return $this->redirectToRoute('product');
        }

        return $this->render("standard/product.html.twig", [
            'formProduct' => $formProduct->createView()
        ]);
    }

    #[Route('/example-page', name: 'example')]
    public function examplePage(Request $request)
    {
        $formExample = $this->createForm(ExampleType::class);

        $formExample->handleRequest($request);

        if ($formExample->isSubmitted() && $formExample->isValid()) {
            $name = $formExample->get('name')->getData();
            $password = $formExample->get('password')->getData();
            $username = $formExample->get('username')->getData();
        }
        return $this->render("standard/example.html.twig", [
            'formExample' => $formExample->createView()
        ]);
    }
}
