<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-products',
    description: 'Add Woodora products to the database',
)]
class LoadProductsCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {

        $io = new SymfonyStyle($input, $output);

        $categories = $this->entityManager
            ->getRepository(Category::class)
            ->findAll();

        if (empty($categories)) {

            $io->error('No categories found in the database.');

            return Command::FAILURE;
        }

        $productsData = [

            'Dining' => [
                [
                    'name' => 'Dining Table',
                    'description' => 'Elegant wooden dining table for modern interiors.',
                    'price' => '899.00',
                    'image' => 'dining-table.jpg',
                ],
                [
                    'name' => 'Dining Chair',
                    'description' => 'Comfortable and stylish chair for your dining room.',
                    'price' => '199.00',
                    'image' => 'dining-chair.jpg',
                ],
                [
                    'name' => 'Wooden Cabinet',
                    'description' => 'Practical wooden cabinet with a refined design.',
                    'price' => '649.00',
                    'image' => 'dining-cabinet.jpg',
                ],
            ],

            'Living' => [
                [
                    'name' => 'Modern Sofa',
                    'description' => 'Comfortable modern sofa designed for your living room.',
                    'price' => '1299.00',
                    'image' => 'modern-sofa.jpg',
                ],
                [
                    'name' => 'Coffee Table',
                    'description' => 'Minimalist coffee table with a natural wooden finish.',
                    'price' => '499.00',
                    'image' => 'coffee-table.jpg',
                ],
                [
                    'name' => 'TV Cabinet',
                    'description' => 'Modern TV cabinet with elegant storage space.',
                    'price' => '749.00',
                    'image' => 'tv-cabinet.jpg',
                ],
            ],

            'Bedroom' => [
                [
                    'name' => 'Modern Bed',
                    'description' => 'Elegant bed designed to bring comfort and style to your bedroom.',
                    'price' => '1499.00',
                    'image' => 'modern-bed.jpg',
                ],
                [
                    'name' => 'Nightstand',
                    'description' => 'Compact wooden nightstand with practical storage.',
                    'price' => '299.00',
                    'image' => 'nightstand.jpg',
                ],
                [
                    'name' => 'Wardrobe',
                    'description' => 'Spacious wardrobe with a modern wooden design.',
                    'price' => '1199.00',
                    'image' => 'wardrobe.jpg',
                ],
            ],

            'Office' => [
                [
                    'name' => 'Office Desk',
                    'description' => 'Professional wooden desk designed for a productive workspace.',
                    'price' => '699.00',
                    'image' => 'office-desk.jpg',
                ],
                [
                    'name' => 'Office Chair',
                    'description' => 'Ergonomic office chair combining comfort and modern design.',
                    'price' => '499.00',
                    'image' => 'office-chair.jpg',
                ],
                [
                    'name' => 'Bookshelf',
                    'description' => 'Modern bookshelf offering practical and elegant storage.',
                    'price' => '599.00',
                    'image' => 'bookshelf.jpg',
                ],
            ],

            'Outdoor' => [
                [
                    'name' => 'Garden Chair',
                    'description' => 'Comfortable outdoor chair suitable for gardens and terraces.',
                    'price' => '249.00',
                    'image' => 'garden-chair.jpg',
                ],
                [
                    'name' => 'Outdoor Table',
                    'description' => 'Durable outdoor table designed for your terrace.',
                    'price' => '599.00',
                    'image' => 'outdoor-table.jpg',
                ],
                [
                    'name' => 'Lounge Set',
                    'description' => 'Elegant outdoor lounge set for relaxing moments.',
                    'price' => '1599.00',
                    'image' => 'lounge-set.jpg',
                ],
            ],
        ];

        $count = 0;

        foreach ($categories as $category) {

            $categoryName = $category->getName();

            if (!isset($productsData[$categoryName])) {
                continue;
            }

            foreach ($productsData[$categoryName] as $data) {

                $product = new Product();

                $product->setName($data['name']);
                $product->setDescription($data['description']);
                $product->setPrice($data['price']);
                $product->setImage($data['image']);
                $product->setCategory($category);

                $this->entityManager->persist($product);

                $count++;
            }
        }

        $this->entityManager->flush();

        $io->success(sprintf(
            '%d products have been added successfully.',
            $count
        ));

        return Command::SUCCESS;
    }
}