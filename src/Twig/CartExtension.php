<?php

namespace App\Twig;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class CartExtension extends AbstractExtension
{

    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager
    )
    {
    }



    public function getFunctions(): array
    {
        return [

            new TwigFunction(
                'cart_count',
                [$this, 'getCartCount']
            ),


            new TwigFunction(
                'cart_products',
                [$this, 'getCartProducts']
            )

        ];
    }



    public function getCartCount(): int
    {

        $session = $this->requestStack->getSession();

        $cart = $session->get('cart', []);

        return array_sum($cart);
    }





    public function getCartProducts(): array
    {

        $session = $this->requestStack->getSession();

        $cart = $session->get('cart', []);


        $products = [];


        foreach($cart as $id=>$quantity){

            $product = $this->entityManager
                ->getRepository(Product::class)
                ->find($id);


            if($product){

                $products[] = [
                    'product'=>$product,
                    'quantity'=>$quantity
                ];

            }

        }


        return $products;
    }

}