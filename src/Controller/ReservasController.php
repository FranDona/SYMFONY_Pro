<?php

namespace App\Controller;

use App\Entity\Reservas;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\InsertarReservasType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ReservasController extends AbstractController
{
    #[Route('/reservas/consultarJSON', name: 'app_reservas_consultarJSON')]
public function consultarJSON(EntityManagerInterface $gestorEntidades): JsonResponse
{
    // Endpoint de ejemplo: http://localhost:8000/reservas/consultarJSON
    $repoReservas = $gestorEntidades->getRepository(Reservas::class);
    $reservas = $repoReservas->findAll();

    $json = [];
    foreach ($reservas as $reserva) {
        $json[] = [
            "fechaInicio" => $reserva->getFechaInicio()->format('Y-m-d H:i:s'),
            "fechaFin" => $reserva->getFechaFin()->format('Y-m-d H:i:s'),
            "habitacion_numero" => $reserva->getHabitacion()->getNumero(),
            "cliente_dni" => $reserva->getCliente()->getDni(),
            "activo" => $reserva->isActivo(),
        ];
    }
    return new JsonResponse($json);
}


    #[Route('/reservas/consultar', name: 'app_reservas_consultar')]
    public function consultar(EntityManagerInterface $gestorEntidades): Response
    {
        // Endpoint de ejemplo: http://localhost:8000/reservas/consultar
        $repoReservas = $gestorEntidades->getRepository(Reservas::class);
        $reserva = $repoReservas->findAll();

        return $this->render('reservas/consultarReservas.twig', [
            'controller_name' => 'ReservasController',
            'reserva' => $reserva,  // Aquí se pasa 'reserva' en lugar de 'reservas'
        ]);
    }


    #[Route('/reservas/insertar', name: 'app_reservas_insertar')]
    public function insertar(EntityManagerInterface $gestorEntidades, Request $solicitud): Response
    {
        // Endpoint de ejemplo: http://localhost:8000/reservas/insertar
        $reserva = new Reservas();

        $formulario = $this->createForm(InsertarReservasType::class, $reserva);
        $formulario->handleRequest($solicitud);

        if($formulario->isSubmitted() && $formulario->isValid()) {
            $gestorEntidades->persist($reserva);
            $gestorEntidades->flush();
            $this->addFlash("success", "Reserva insertada");
            return $this->redirectToRoute('app_reservas_consultar');
        } else {
            return $this->render('reservas/index.html.twig', [
                'controller_name' => 'ReservasController',
                "miForm" => $formulario->createView(),
            ]);
        }

    }

    #[Route('/reservas/eliminar/{id}', name: 'app_eliminar_reserva')]
    public function eliminarReserva(EntityManagerInterface $entityManager, int $id): Response
    {
        $reserva = $entityManager->getRepository(Reservas::class)->find($id);

        if (!$reserva) {
            throw $this->createNotFoundException('No se encontró la reserva con el ID: ' . $id);
        }

        $entityManager->remove($reserva);
        $entityManager->flush();

        // Redirige a la página de consultar reservas después de eliminar la reserva
        return $this->redirectToRoute('app_reservas_consultar');
    }

    #[Route('/reservas/borrar-logico/{id}', name: 'app_borrar_logico_reserva')]
    public function borrarLogicoReserva(EntityManagerInterface $entityManager, int $id): Response
    {
        $reserva = $entityManager->getRepository(Reservas::class)->find($id);

        if (!$reserva) {
            throw $this->createNotFoundException('No se encontró la reserva con el ID: ' . $id);
        }

        // Realizar el borrado lógico estableciendo el estado activo en falso
        $reserva->setActivo(false);
        $entityManager->flush();

        // No es necesario redirigir, ya que queremos que la página actual se actualice
        return $this->redirectToRoute('app_reservas_consultar');
    }


    #[Route('/reservas/editar/{id}', name: 'app_reservas_editar')]
    public function editar(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $reserva = $entityManager->getRepository(Reservas::class)->find($id);
    
        if (!$reserva) {
            throw $this->createNotFoundException('No se encontró la reserva con el id: ' . $id);
        }
    
        $formulario = $this->createForm(InsertarReservasType::class, $reserva);
        $formulario->handleRequest($request);
    
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $entityManager->flush();
            $this->addFlash("success", "Reserva actualizada correctamente");
            return $this->redirectToRoute('app_reservas_consultar');
        }
    
        return $this->render('reservas/editarReserva.twig', [
            'controller_name' => 'ReservasController',
            "formulario" => $formulario->createView(),
        ]);
    }
}
