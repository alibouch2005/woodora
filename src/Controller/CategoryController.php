<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{slug}', name: 'category_products')]
    public function products(
        string $slug,
        CategoryRepository $categoryRepository
    ): Response {

        $category = null;

        foreach ($categoryRepository->findAll() as $currentCategory) {
            if ($currentCategory->getSlug() === $slug) {
                $category = $currentCategory;
                break;
            }
        }

        if (!$category) {
            throw $this->createNotFoundException(
                'Category not found'
            );
        }

        $products = $category->getProducts();

        return $this->render('category/products.html.twig', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
