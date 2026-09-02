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

        foreach ($cart as $id => $quantity) {
            $product = $entityManager
                ->getRepository(Product::class)
                ->find($id);

            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }

        return $this->render('cart/index.html.twig', [
            'products' => $products,
        ]);
    }
}