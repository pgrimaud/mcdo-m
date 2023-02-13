<?php

namespace App\Controller;

use App\Repository\DistrictRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends AbstractController
{
    public function navbar(DistrictRepository $districtRepository): Response
    {
        return $this->render('menu/navbar.html.twig', [
            'districts' => $districtRepository->findAll(),
        ]);
    }
}
