<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(
        int $id,
        SessionInterface $session
    ): Response {

        $cart = $session->get('cart', []);

        if (!isset($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }


    #[Route('/cart', name: 'cart_index')]
    public function index(
        SessionInterface $session,
        EntityManagerInterface $entityManager
    ): Response {

        $cart = $session->get('cart', []);

        $products = [];

        $total = 0;


        foreach ($cart as $id => $quantity) {

            $product = $entityManager
                ->getRepository(Product::class)
                ->find($id);


            if ($product) {

                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];


                $total += $product->getPrice() * $quantity;
            }
        }


        return $this->render('cart/index.html.twig', [
            'products' => $products,
            'total' => $total,
        ]);
    }



    #[Route('/cart/increase/{id}', name: 'cart_increase')]
    public function increase(
        int $id,
        SessionInterface $session
    ): Response {


        $cart = $session->get('cart', []);


        if (isset($cart[$id])) {
            $cart[$id]++;
        }


        $session->set('cart', $cart);


        return $this->redirectToRoute('cart_index');
    }



    #[Route('/cart/decrease/{id}', name: 'cart_decrease')]
    public function decrease(
        int $id,
        SessionInterface $session
    ): Response {


        $cart = $session->get('cart', []);


        if (isset($cart[$id])) {

            $cart[$id]--;


            if ($cart[$id] <= 0) {
                unset($cart[$id]);
            }

        }


        $session->set('cart', $cart);


        return $this->redirectToRoute('cart_index');
    }



    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(
        int $id,
        SessionInterface $session
    ): Response {


        $cart = $session->get('cart', []);


        if (isset($cart[$id])) {
            unset($cart[$id]);
        }


        $session->set('cart', $cart);


        return $this->redirectToRoute('cart_index');
    }

}