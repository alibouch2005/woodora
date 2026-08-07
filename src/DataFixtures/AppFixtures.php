<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        $categories = [

            [
                'name' => 'Dining',
                'image' => 'dining.jpg'
            ],

            [
                'name' => 'Living',
                'image' => 'living.jpg'
            ],

            [
                'name' => 'Bedroom',
                'image' => 'bedroom.jpg'
            ],

            [
                'name' => 'Office',
                'image' => 'office.jpg'
            ],

            [
                'name' => 'Outdoor',
                'image' => 'outdoor.jpg'
            ]

        ];


        foreach($categories as $data){

            $category = new Category();

            $category->setName($data['name']);
            $category->setImage($data['image']);

            $manager->persist($category);

        }


        $manager->flush();

    }
}