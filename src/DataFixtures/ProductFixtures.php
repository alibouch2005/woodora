<?php


namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface as FixturesBundleFixtureGroupInterface;
use Doctrine\Common\DataFixtures\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements FixturesBundleFixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['products'];
    }

    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findAll();

        foreach ($categories as $category) {

            $products = [];

            switch ($category->getName()) {

                case 'Dining':
                    $products = [
                        [
                            'name' => 'Dining Table',
                            'description' => 'Elegant wooden dining table for modern interiors.',
                            'price' => '899.00',
                            'image' => 'dining-table.jpg'
                        ],
                        [
                            'name' => 'Dining Chair',
                            'description' => 'Comfortable and stylish chair for your dining room.',
                            'price' => '199.00',
                            'image' => 'dining-chair.jpg'
                        ],
                        [
                            'name' => 'Wooden Cabinet',
                            'description' => 'Practical wooden cabinet with a refined design.',
                            'price' => '649.00',
                            'image' => 'dining-cabinet.jpg'
                        ]
                    ];
                    break;


                case 'Living':
                    $products = [
                        [
                            'name' => 'Modern Sofa',
                            'description' => 'Comfortable modern sofa designed for your living room.',
                            'price' => '1299.00',
                            'image' => 'modern-sofa.jpg'
                        ],
                        [
                            'name' => 'Coffee Table',
                            'description' => 'Minimalist coffee table with a natural wooden finish.',
                            'price' => '499.00',
                            'image' => 'coffee-table.jpg'
                        ],
                        [
                            'name' => 'TV Cabinet',
                            'description' => 'Modern TV cabinet with elegant storage space.',
                            'price' => '749.00',
                            'image' => 'tv-cabinet.jpg'
                        ]
                    ];
                    break;


                case 'Bedroom':
                    $products = [
                        [
                            'name' => 'Modern Bed',
                            'description' => 'Elegant bed designed to bring comfort and style to your bedroom.',
                            'price' => '1499.00',
                            'image' => 'modern-bed.jpg'
                        ],
                        [
                            'name' => 'Nightstand',
                            'description' => 'Compact wooden nightstand with practical storage.',
                            'price' => '299.00',
                            'image' => 'nightstand.jpg'
                        ],
                        [
                            'name' => 'Wardrobe',
                            'description' => 'Spacious wardrobe with a modern wooden design.',
                            'price' => '1199.00',
                            'image' => 'wardrobe.jpg'
                        ]
                    ];
                    break;


                case 'Office':
                    $products = [
                        [
                            'name' => 'Office Desk',
                            'description' => 'Professional wooden desk designed for a productive workspace.',
                            'price' => '699.00',
                            'image' => 'office-desk.jpg'
                        ],
                        [
                            'name' => 'Office Chair',
                            'description' => 'Ergonomic office chair combining comfort and modern design.',
                            'price' => '499.00',
                            'image' => 'office-chair.jpg'
                        ],
                        [
                            'name' => 'Bookshelf',
                            'description' => 'Modern bookshelf offering practical and elegant storage.',
                            'price' => '599.00',
                            'image' => 'bookshelf.jpg'
                        ]
                    ];
                    break;


                case 'Outdoor':
                    $products = [
                        [
                            'name' => 'Garden Chair',
                            'description' => 'Comfortable outdoor chair suitable for gardens and terraces.',
                            'price' => '249.00',
                            'image' => 'garden-chair.jpg'
                        ],
                        [
                            'name' => 'Outdoor Table',
                            'description' => 'Durable outdoor table designed for your terrace.',
                            'price' => '599.00',
                            'image' => 'outdoor-table.jpg'
                        ],
                        [
                            'name' => 'Lounge Set',
                            'description' => 'Elegant outdoor lounge set for relaxing moments.',
                            'price' => '1599.00',
                            'image' => 'lounge-set.jpg'
                        ]
                    ];
                    break;
            }


            foreach ($products as $data) {

                $product = new Product();

                $product->setName($data['name']);
                $product->setDescription($data['description']);
                $product->setPrice($data['price']);
                $product->setImage($data['image']);
                $product->setCategory($category);

                $manager->persist($product);
            }
        }


        $manager->flush();
    }
}