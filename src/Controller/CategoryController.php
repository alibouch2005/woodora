<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class CategoryController extends AbstractController
{


    #[Route('/category/{name}', name:'category_products')]
    public function products(string $name): Response
    {


        return $this->render('category/products.html.twig',[

            'category'=>$name

        ]);

    }


}