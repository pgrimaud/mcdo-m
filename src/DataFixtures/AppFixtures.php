<?php

namespace App\DataFixtures;

use App\Entity\District;
use App\Entity\Product;
use App\Entity\ProductRestaurant;
use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $district = new District();
            $district->setName('District ' . $i);
            $district->setPopulation(rand(50000, 250000));
            $manager->persist($district);
        }

        for ($i = 1; $i <= 10; $i++) {
            $district = new Product();
            $district->setName('Product ' . $i);
            $manager->persist($district);
        }

        $manager->flush();

        $districtRepository = $manager->getRepository(District::class);
        $districts = $districtRepository->findAll();

        foreach ($districts as $district) {
            for ($i = 1; $i <= 10; $i++) {
                $restaurant = new Restaurant();
                $restaurant->setName('Restaurant ' . $i . ' ' . $district->getId());
                $restaurant->setDistrict($district);
                $manager->persist($restaurant);
            }
        }

        $manager->flush();

        $restaurants = $manager->getRepository(Restaurant::class)->findAll();
        $products = $manager->getRepository(Product::class)->findAll();

        foreach ($restaurants as $restaurant) {
            foreach ($products as $product) {
                $productRestaurant = new ProductRestaurant();
                $productRestaurant->setRestaurant($restaurant);
                $productRestaurant->setProduct($product);
                $productRestaurant->setPrice(rand(50, 100) / 10);
                $productRestaurant->setStock(rand(50, 200));
                $manager->persist($productRestaurant);
            }
        }

        $manager->flush();
    }
}
