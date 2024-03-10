<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConsultaJoinController extends AbstractController
{
    #[Route('/consultaJOIN', name: 'app_consultaJOIN')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Endpoint de ejemplo: http://localhost:8000/consultaJOIN
        $query = $entityManager->createQuery(
            'SELECT h.numero AS numero_habitacion, r.fechaInicio, r.fechaFin, c.dni AS dni_cliente
            FROM App\Entity\Reservas r
            JOIN r.habitacion h
            JOIN r.cliente c'
        );

        $resultados = $query->getResult();

        return $this->render('consultaJoin/index.html.twig', [
            'resultados' => $resultados,
        ]);
    }
}
