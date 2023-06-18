<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrdenDeTrabajoController extends AbstractController
{
    #[Route('/orden/de/trabajo', name: 'app_orden_de_trabajo')]
    public function index(): Response
    {
        return $this->render('orden_de_trabajo/index.html.twig', [
            'controller_name' => 'OrdenDeTrabajoController',
        ]);
    }
}
