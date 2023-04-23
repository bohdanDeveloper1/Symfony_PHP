<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\Type\CategoryType;
use App\Form\Type\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $repository
     * @return Response
     */

    // відображає всі продукти (List issues в меню в браузері)
    #[Route('/products')]
    public function show(EntityManagerInterface $entityManager, ProductRepository $repository): Response
    {
        //Method 1
        // $products = $entityManager->getRepository(Product::class)->findAll();

        //Method 2
        $products = $repository->findAll();

        return $this->render('products/products.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $repository
     * @return Response
     */

    // відображає всі категорії  (List of Categories в меню в браузері)
    #[Route('/categories')]
    public function categories(EntityManagerInterface $entityManager, CategoryRepository $repository): Response
    {
        //Method 2
        $categories = $repository->findAll();


        return $this->render('products/categories.html.twig', [
            'categories' => $categories
        ]);
    }


    /**
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $repository
     * @return Response
     */

    #[Route('/product/{id}')]
    public function showById(ProductRepository $repository, int $id): Response
    {
        $product = $repository->find($id);

        return $this->render('products/product.html.twig', [
            'product' => $product
        ]);
    }

        // тут проблеми
    #[Route('/category/add')]
    public function addCategory(Request $request, EntityManagerInterface $entityManager)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $category = $form->getData();
            $category->setCreatedAt(new DateTime());

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($category);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->render('base.html.twig', []);
        }


        return $this->render('products/newcategory.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('/productAdd')]
    public function addCProduct(Request $request, EntityManagerInterface $entityManager)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $product = $form->getData();

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($product);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('home');
        }

        return $this->render('products/newproduct.html.twig', [
            'form' => $form
        ]);
    }
}