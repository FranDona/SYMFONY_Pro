<?php

namespace App\Controller;

use App\Entity\Habitaciones;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Form\InsertarHabitacionesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


class HabitacionesController extends AbstractController
{

    #[Route('/habitaciones', name: 'app_redireccionar_habitaciones')]
    public function redireccionarHabitaciones(): RedirectResponse
    {
        return $this->redirectToRoute('app_habitaciones_consultar');
    }

    #[Route('/habitaciones/consultarJSON', name: 'app_habitaciones_consultarJSON')]
    public function consultarJSON(EntityManagerInterface $gestorEntidades): JsonResponse
    {
        // Endpoint de ejemplo: http://localhost:8000/habitaciones/consultarJSON
        $repoHabitaciones = $gestorEntidades->getRepository(Habitaciones::class);
        $habitaciones = $repoHabitaciones->findAll();

        $json = [];
        foreach ($habitaciones as $habitacion) {
            $json[] = [
                "numero" => $habitacion->getNumero(),
                "precioNoche" => $habitacion->getPrecioNoche(),
                "disponible" => $habitacion->isDisponible(),
            ];
        }
        return new JsonResponse($json);
    }

    
    #[Route('/habitaciones/consultar', name: 'app_habitaciones_consultar')]
    public function consultar(EntityManagerInterface $gestorEntidades): Response
    {
        // Endpoint de ejemplo: http://localhost:8000/clientes/consultar
        $repoHabitaciones = $gestorEntidades->getRepository(Habitaciones::class);
        $habitaciones = $repoHabitaciones->findAll();

        return $this->render('habitaciones/consultarHabitaciones.twig', [
            'controller_name' => 'HabitacionesController',
            'habitaciones' => $habitaciones,
        ]);
    }

    #[Route('/habitaciones/insertar', name: 'app_habitaciones_insertar')]
    public function insertar(EntityManagerInterface $gestorEntidades, Request $solicitud): Response
    {
        // Endpoint de ejemplo: http://localhost:8000/habitaciones/insertar
        $habitacion = new Habitaciones();

        $formulario = $this->createForm(InsertarHabitacionesType::class, $habitacion);
        $formulario->handleRequest($solicitud);

        if($formulario->isSubmitted() && $formulario->isValid()) {
            $gestorEntidades->persist($habitacion);
            $gestorEntidades->flush();
            $this->addFlash("success", "Habitacion insertada");
            return $this->redirectToRoute('app_habitaciones_consultar');
        } else {
            return $this->render('habitaciones/index.html.twig', [
                'controller_name' => 'HabitacionesController',
                "miForm" => $formulario->createView(),
            ]);
        }

    }

    
    #[Route('/habitaciones/eliminar/{numero}', name: 'app_eliminar_habitacion')]
    public function eliminarHabitacion(EntityManagerInterface $entityManager, int $numero): Response
    {
        $habitacion = $entityManager->getRepository(Habitaciones::class)->find($numero);

        if (!$habitacion) {
            throw $this->createNotFoundException('No se encontró la habitación con el numero: ' . $numero);
        }

        // Eliminar todas las reservas asociadas a esta habitación
        $reservas = $habitacion->getReservas();
        foreach ($reservas as $reserva) {
            $entityManager->remove($reserva);
        }

        $entityManager->remove($habitacion);
        $entityManager->flush();

        return $this->redirectToRoute('app_habitaciones_consultar');
    }

    #[Route('/habitaciones/editar/{numero}', name: 'app_habitaciones_editar')]
    public function editar(EntityManagerInterface $entityManager, Request $request, int $numero): Response
    {
        $habitacion = $entityManager->getRepository(Habitaciones::class)->find($numero);
    
        if (!$habitacion) {
            throw $this->createNotFoundException('No se encontró la habitación con el numero: ' . $numero);
        }
    
        $formulario = $this->createForm(InsertarHabitacionesType::class, $habitacion);
        $formulario->handleRequest($request);
    
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $entityManager->flush();
            $this->addFlash("success", "Habitación actualizada correctamente");
            return $this->redirectToRoute('app_habitaciones_consultar');
        }
    
        return $this->render('habitaciones/editarHabitacion.twig', [
            'controller_name' => 'HabitacionesController',
            "miForm" => $formulario->createView(),
        ]);
    }
    

}
