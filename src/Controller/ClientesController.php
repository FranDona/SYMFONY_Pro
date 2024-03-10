<?php

namespace App\Controller;

use App\Entity\Clientes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\InsertarClientesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;



class ClientesController extends AbstractController
{
    #[Route('/clientes/consultarJSON', name: 'app_clientes_consultarJSON')]
    public function consultarJSON(EntityManagerInterface $gestorEntidades): JsonResponse
    {
        // Endpoint de ejemplo: http://localhost:8000/clientes/consultarJSON
        $repoClientes = $gestorEntidades->getRepository(Clientes::class);
        $clientes = $repoClientes->findAll();

        $json = [];
        foreach ($clientes as $cliente) {
            $json[] = [
                "nombre" => $cliente->getnombre(),
                "apellido" => $cliente->getapellido(),
                "telefono" => $cliente->gettelefono(),
            ];
        }
        return new JsonResponse($json);
    }

    #[Route('/clientes/consultar', name: 'app_clientes_consultar')]
    public function consultar(EntityManagerInterface $gestorEntidades): Response
        {
        // Endpoint de ejemplo: http://localhost:8000/clientes/consultar
        $repoClientes = $gestorEntidades->getRepository(Clientes::class);
        $clientes = $repoClientes->findAll();

        return $this->render('clientes/consultarClientes.twig', [
            'controller_name' => 'ClientesController',
            'cliente' => $clientes,
        ]);
    }

    #[Route('/clientes/insertar', name: 'app_clientes_insertar')]
    public function insertar(EntityManagerInterface $gestorEntidades, Request $solicitud): Response
    {
        // Endpoint de ejemplo: http://localhost:8000/clientes/insertar
        $cliente = new Clientes();

        $formulario = $this->createForm(InsertarClientesType::class, $cliente);
        $formulario->handleRequest($solicitud);

        if($formulario->isSubmitted() && $formulario->isValid()) {
            $gestorEntidades->persist($cliente);
            $gestorEntidades->flush();
            $this->addFlash("success", "Cliente insertado");
            return $this->redirectToRoute('app_clientes_consultar');
        } else {
            return $this->render('clientes/index.html.twig', [
                'controller_name' => 'ClientesController',
                "miForm" => $formulario->createView(),
            ]);
        }

    }

}
