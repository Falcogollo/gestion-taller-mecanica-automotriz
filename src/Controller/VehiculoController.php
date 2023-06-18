<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiculoController extends AbstractController
{
    #[Route('/vehiculo', name: 'app_vehiculo')]
    public function index(): Response
    {
        return $this->render('vehiculo/index.html.twig', [
            'controller_name' => 'VehiculoController',
        ]);
    }
}
